<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

class SitemapService
{
    /**
     * Maximum sitemap file size.
     *
     * 50 KB = 51200 bytes
     */
    private const MAX_FILE_SIZE = 51200;

    private string $sitemapDirectory;

    public function __construct()
    {
        $this->sitemapDirectory = public_path('sitemaps');
    }

    /**
     * Generate complete sitemap.
     */
    public function generate(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Make sure sitemap directory exists
        |--------------------------------------------------------------------------
        */

        if (!File::exists($this->sitemapDirectory)) {
            File::makeDirectory(
                $this->sitemapDirectory,
                0755,
                true
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Delete old sitemap files
        |--------------------------------------------------------------------------
        */

        $this->deleteOldSitemaps();


        /*
        |--------------------------------------------------------------------------
        | 1. NORMAL PAGES
        |--------------------------------------------------------------------------
        |
        | Normal static GET routes.
        |
        */

        $pageUrls = $this->getPageUrls();


        /*
        |--------------------------------------------------------------------------
        | 2. OCCASION URLs
        |--------------------------------------------------------------------------
        |
        | Occasion URLs are also stored inside:
        |
        | sitemap-pages-1.xml
        |
        | Example:
        |
        | /salwar-kameez/party
        | /salwar-kameez/festival
        |
        */

        $occasionUrls = $this->getOccasionUrls();


        /*
        |--------------------------------------------------------------------------
        | Add occasion URLs to page URLs
        |--------------------------------------------------------------------------
        */

        $pageUrls = array_merge(
            $pageUrls,
            $occasionUrls
        );


        /*
        |--------------------------------------------------------------------------
        | Remove duplicate page + occasion URLs
        |--------------------------------------------------------------------------
        */

        $pageUrls = collect($pageUrls)
            ->unique('loc')
            ->values()
            ->toArray();


        /*
        |--------------------------------------------------------------------------
        | Create pages sitemap
        |--------------------------------------------------------------------------
        */

        $pageFiles = $this->createSitemapFiles(
            $pageUrls,
            'sitemap-pages'
        );


        /*
        |--------------------------------------------------------------------------
        | 3. PRODUCT URLs
        |--------------------------------------------------------------------------
        */

        $productUrls = $this->getProductUrls();


        /*
        |--------------------------------------------------------------------------
        | Create product sitemap
        |--------------------------------------------------------------------------
        */

        $productFiles = $this->createSitemapFiles(
            $productUrls,
            'sitemap-products'
        );


        /*
        |--------------------------------------------------------------------------
        | 4. COLLECTION / CATEGORY URLs
        |--------------------------------------------------------------------------
        */

        $collectionUrls = $this->getCollectionUrls();


        /*
        |--------------------------------------------------------------------------
        | Create collection sitemap
        |--------------------------------------------------------------------------
        */

        $collectionFiles = $this->createSitemapFiles(
            $collectionUrls,
            'sitemap-collections'
        );


        /*
        |--------------------------------------------------------------------------
        | Combine ALL sitemap files
        |--------------------------------------------------------------------------
        */

        $sitemapFiles = array_merge(
            $pageFiles,
            $productFiles,
            $collectionFiles
        );


        /*
        |--------------------------------------------------------------------------
        | Create main sitemap.xml
        |--------------------------------------------------------------------------
        */

        $this->createSitemapIndex(
            $sitemapFiles
        );
    }


    /**
     * Get all normal/static GET page URLs.
     */
    private function getPageUrls(): array
    {
        $urls = [];


        /*
        |--------------------------------------------------------------------------
        | Get all routes
        |--------------------------------------------------------------------------
        */

        foreach (Route::getRoutes() as $route) {

            /*
            |--------------------------------------------------------------------------
            | Only GET routes
            |--------------------------------------------------------------------------
            */

            if (!in_array('GET', $route->methods())) {
                continue;
            }


            $uri = $route->uri();


            /*
            |--------------------------------------------------------------------------
            | Skip dynamic routes
            |--------------------------------------------------------------------------
            |
            | Example:
            |
            | /products/{slug}
            | /blogs/{slug}
            | /category/{slug}
            |
            */

            if (str_contains($uri, '{')) {
                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | Skip admin routes
            |--------------------------------------------------------------------------
            */

            if (str_starts_with($uri, 'admin')) {
                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | Skip API routes
            |--------------------------------------------------------------------------
            */

            if (str_starts_with($uri, 'api')) {
                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | Product and collection URLs are generated
            | separately.
            |--------------------------------------------------------------------------
            */

            if (
                str_starts_with($uri, 'products/')
                ||
                str_starts_with($uri, 'collections/')
            ) {
                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | Excluded pages
            |--------------------------------------------------------------------------
            */

            if (in_array($uri, [

                'login',
                'register',
                'logout',

                'cart',

                'verify-otp',
                'set-password',

                'forgot-password',
                'forgot-password/verify-otp',
                'forgot-password/reset',

                'verify-email',

                'wishlist',

                'order-success',

                'addresses',

                'checkout',
                'checkout/cancel',
                'checkout/success',
                'checkout/payment',

                'robots.txt',

                'generate-sitemap',

                'auth/google/redirect',
                'auth/google/callback',

                'check-buynow-session',

                'refunds/statistics',

                'track',

                'clear-coupon-session',

                'purchase',

                'sitemap.xml',

            ])) {
                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | Generate normal page URL
            |--------------------------------------------------------------------------
            */

            $urls[] = [
                'loc' => url($uri),

                'lastmod' => null,

                'priority' => '0.8',
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | Remove duplicate URLs
        |--------------------------------------------------------------------------
        */

        return collect($urls)
            ->unique('loc')
            ->values()
            ->toArray();
    }


    /**
     * Get occasion URLs.
     *
     * These URLs will be added to sitemap-pages.
     *
     * Example:
     *
     * /salwar-kameez/party
     * /salwar-kameez/festival
     */
    private function getOccasionUrls(): array
    {
        $urls = [];


        /*
        |--------------------------------------------------------------------------
        | Get products
        |--------------------------------------------------------------------------
        |
        | Change relationship names here if your Product model
        | uses different relationship names.
        |
        */

        $products = Product::with([
            'category',
            'occasion',
        ])->get();


        foreach ($products as $product) {

            /*
            |--------------------------------------------------------------------------
            | Category must exist
            |--------------------------------------------------------------------------
            */

            if (!$product->category) {
                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | Category slug must exist
            |--------------------------------------------------------------------------
            */

            if (empty($product->category->slug)) {
                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | Get occasion
            |--------------------------------------------------------------------------
            */

            $occasion = $product->occasion;


            /*
            |--------------------------------------------------------------------------
            | No occasion
            |--------------------------------------------------------------------------
            */

            if (!$occasion) {
                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | Handle multiple occasions
            |--------------------------------------------------------------------------
            |
            | If occasion relationship returns a collection:
            |
            | Product -> Party
            | Product -> Festival
            |
            */

            if ($occasion instanceof \Illuminate\Support\Collection) {

                foreach ($occasion as $occasionItem) {

                    if (empty($occasionItem->slug)) {
                        continue;
                    }


                    $urls[] = [
                        'loc' => url(
                            '/' .
                            $product->category->slug .
                            '/' .
                            $occasionItem->slug
                        ),

                        'lastmod' => $product->updated_at
                            ? $product->updated_at->toISOString()
                            : now()->toISOString(),

                        'priority' => '0.6',
                    ];
                }

            } else {

                /*
                |--------------------------------------------------------------------------
                | Handle single occasion
                |--------------------------------------------------------------------------
                */

                if (empty($occasion->slug)) {
                    continue;
                }


                $urls[] = [
                    'loc' => url(
                        '/' .
                        $product->category->slug .
                        '/' .
                        $occasion->slug
                    ),

                    'lastmod' => $product->updated_at
                        ? $product->updated_at->toISOString()
                        : now()->toISOString(),

                    'priority' => '0.6',
                ];
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Remove duplicate occasion URLs
        |--------------------------------------------------------------------------
        */

        return collect($urls)
            ->unique('loc')
            ->values()
            ->toArray();
    }


    /**
     * Get all product URLs.
     */
    private function getProductUrls(): array
    {
        $urls = [];


        /*
        |--------------------------------------------------------------------------
        | Get products from database
        |--------------------------------------------------------------------------
        */

        $products = Product::query()->get();


        foreach ($products as $product) {

            /*
            |--------------------------------------------------------------------------
            | Skip product if slug doesn't exist
            |--------------------------------------------------------------------------
            */

            if (empty($product->slug)) {
                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | Product URL
            |--------------------------------------------------------------------------
            */

            $urls[] = [
                'loc' => url(
                    '/products/' . $product->slug
                ),

                'lastmod' => $product->updated_at
                    ? $product->updated_at->toISOString()
                    : now()->toISOString(),

                'priority' => '0.8',
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | Remove duplicate URLs
        |--------------------------------------------------------------------------
        */

        return collect($urls)
            ->unique('loc')
            ->values()
            ->toArray();
    }


    /**
     * Get all collection/category URLs.
     */
    private function getCollectionUrls(): array
    {
        $urls = [];


        /*
        |--------------------------------------------------------------------------
        | Get categories from database
        |--------------------------------------------------------------------------
        */

        $collections = Category::query()->get();


        foreach ($collections as $collection) {

            /*
            |--------------------------------------------------------------------------
            | Skip if slug doesn't exist
            |--------------------------------------------------------------------------
            */

            if (empty($collection->slug)) {
                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | Collection URL
            |--------------------------------------------------------------------------
            */

            $urls[] = [
                'loc' => url(
                    '/collections/' . $collection->slug
                ),

                'lastmod' => $collection->updated_at
                    ? $collection->updated_at->toISOString()
                    : now()->toISOString(),

                'priority' => '0.7',
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | Remove duplicate URLs
        |--------------------------------------------------------------------------
        */

        return collect($urls)
            ->unique('loc')
            ->values()
            ->toArray();
    }


    /**
     * Create sitemap XML files.
     *
     * Examples:
     *
     * sitemap-pages-1.xml
     * sitemap-pages-2.xml
     *
     * sitemap-products-1.xml
     * sitemap-products-2.xml
     *
     * sitemap-collections-1.xml
     * sitemap-collections-2.xml
     */
    private function createSitemapFiles(
        array $urls,
        string $prefix
    ): array {

        $files = [];

        $currentUrls = [];

        $fileNumber = 1;


        foreach ($urls as $item) {

            /*
            |--------------------------------------------------------------------------
            | Test XML with new URL
            |--------------------------------------------------------------------------
            */

            $testUrls = $currentUrls;

            $testUrls[] = $item;


            $xml = $this->buildUrlSetXml(
                $testUrls
            );


            /*
            |--------------------------------------------------------------------------
            | If adding this URL makes file > 50 KB
            |--------------------------------------------------------------------------
            */

            if (
                count($currentUrls) > 0
                &&
                strlen($xml) > self::MAX_FILE_SIZE
            ) {

                /*
                |--------------------------------------------------------------------------
                | Save current sitemap
                |--------------------------------------------------------------------------
                */

                $filename = "{$prefix}-{$fileNumber}.xml";


                File::put(
                    $this->sitemapDirectory . '/' . $filename,
                    $this->buildUrlSetXml(
                        $currentUrls
                    )
                );


                $files[] = $filename;


                /*
                |--------------------------------------------------------------------------
                | Next file
                |--------------------------------------------------------------------------
                */

                $fileNumber++;


                /*
                |--------------------------------------------------------------------------
                | Start new file with current URL
                |--------------------------------------------------------------------------
                */

                $currentUrls = [$item];

            } else {

                $currentUrls = $testUrls;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Save remaining URLs
        |--------------------------------------------------------------------------
        */

        if (count($currentUrls) > 0) {

            $filename = "{$prefix}-{$fileNumber}.xml";


            File::put(
                $this->sitemapDirectory . '/' . $filename,
                $this->buildUrlSetXml(
                    $currentUrls
                )
            );


            $files[] = $filename;
        }


        return $files;
    }


    /**
     * Build URL sitemap XML.
     */
    private function buildUrlSetXml(
        array $urls
    ): string {

        /*
        |--------------------------------------------------------------------------
        | XML header
        |--------------------------------------------------------------------------
        */

        $xml =
            '<?xml version="1.0" encoding="UTF-8"?>'
            . PHP_EOL;


        /*
        |--------------------------------------------------------------------------
        | URLSET
        |--------------------------------------------------------------------------
        */

        $xml .=
            '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'
            . PHP_EOL;


        /*
        |--------------------------------------------------------------------------
        | URLs
        |--------------------------------------------------------------------------
        */

        foreach ($urls as $item) {

            $xml .= "    <url>" . PHP_EOL;


            /*
            |--------------------------------------------------------------------------
            | Location
            |--------------------------------------------------------------------------
            */

            $xml .=
                '        <loc>'
                . htmlspecialchars(
                    $item['loc'],
                    ENT_XML1
                )
                . '</loc>'
                . PHP_EOL;


            /*
            |--------------------------------------------------------------------------
            | Last modified
            |--------------------------------------------------------------------------
            */

            if (!empty($item['lastmod'])) {

                $xml .=
                    '        <lastmod>'
                    . htmlspecialchars(
                        $item['lastmod'],
                        ENT_XML1
                    )
                    . '</lastmod>'
                    . PHP_EOL;
            }


            /*
            |--------------------------------------------------------------------------
            | Change frequency
            |--------------------------------------------------------------------------
            */

            $xml .=
                '        <changefreq>daily</changefreq>'
                . PHP_EOL;


            /*
            |--------------------------------------------------------------------------
            | Priority
            |--------------------------------------------------------------------------
            */

            if (!empty($item['priority'])) {

                $xml .=
                    '        <priority>'
                    . htmlspecialchars(
                        $item['priority'],
                        ENT_XML1
                    )
                    . '</priority>'
                    . PHP_EOL;
            }


            $xml .= "    </url>" . PHP_EOL;
        }


        /*
        |--------------------------------------------------------------------------
        | Close URLSET
        |--------------------------------------------------------------------------
        */

        $xml .= '</urlset>';


        return $xml;
    }


    /**
     * Create public/sitemap.xml.
     *
     * This contains links to:
     *
     * sitemap-pages-1.xml
     * sitemap-products-1.xml
     * sitemap-collections-1.xml
     */
    private function createSitemapIndex(
        array $sitemapFiles
    ): void {

        /*
        |--------------------------------------------------------------------------
        | XML header
        |--------------------------------------------------------------------------
        */

        $xml =
            '<?xml version="1.0" encoding="UTF-8"?>'
            . PHP_EOL;


        /*
        |--------------------------------------------------------------------------
        | Sitemap index
        |--------------------------------------------------------------------------
        */

        $xml .=
            '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'
            . PHP_EOL;


        /*
        |--------------------------------------------------------------------------
        | Add every sitemap file
        |--------------------------------------------------------------------------
        */

        foreach ($sitemapFiles as $filename) {

            $xml .= "    <sitemap>" . PHP_EOL;


            /*
            |--------------------------------------------------------------------------
            | Sitemap URL
            |--------------------------------------------------------------------------
            */

            $xml .=
                '        <loc>'
                . htmlspecialchars(
                    url('/sitemaps/' . $filename),
                    ENT_XML1
                )
                . '</loc>'
                . PHP_EOL;


            /*
            |--------------------------------------------------------------------------
            | Last modified
            |--------------------------------------------------------------------------
            */

            $xml .=
                '        <lastmod>'
                . now()->toISOString()
                . '</lastmod>'
                . PHP_EOL;


            $xml .= "    </sitemap>" . PHP_EOL;
        }


        /*
        |--------------------------------------------------------------------------
        | Close sitemap index
        |--------------------------------------------------------------------------
        */

        $xml .= '</sitemapindex>';


        /*
        |--------------------------------------------------------------------------
        | Save public/sitemap.xml
        |--------------------------------------------------------------------------
        */

        File::put(
            public_path('sitemap.xml'),
            $xml
        );
    }


    /**
     * Delete previously generated sitemap files.
     */
    private function deleteOldSitemaps(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Check directory
        |--------------------------------------------------------------------------
        */

        if (!File::exists($this->sitemapDirectory)) {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Delete generated sitemap files
        |--------------------------------------------------------------------------
        */

        foreach (
            File::files($this->sitemapDirectory)
            as $file
        ) {

            if (
                str_starts_with(
                    $file->getFilename(),
                    'sitemap-'
                )
            ) {

                File::delete(
                    $file->getPathname()
                );
            }
        }
    }
}