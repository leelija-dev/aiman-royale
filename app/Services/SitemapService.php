<?php

namespace App\Services;

// use App\Models\Blog;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
class SitemapService
{
    /**
     * Maximum sitemap file size.
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
        // Make sure directory exists
        if (!File::exists($this->sitemapDirectory)) {
            File::makeDirectory($this->sitemapDirectory, 0755, true);
        }

        // Delete old sitemap files
        $this->deleteOldSitemaps();

        /*
         * Collect all URLs here.
         *
         * You can add pages, blogs, products,
         * categories, collections, etc.
         */
        $urls = $this->getUrls();

        // Generate sitemap files
        $sitemapFiles = $this->createSitemapFiles($urls);

        // Generate sitemap.xml index
        $this->createSitemapIndex($sitemapFiles);
    }

    /**
     * Get all URLs that should be indexed.
     */
    private function getUrls(): array
{
    $urls = [];

    /*
    |--------------------------------------------------------------------------
    | All static GET routes
    |--------------------------------------------------------------------------
    */
    foreach (Route::getRoutes() as $route) {

        // Only GET routes
        if (!in_array('GET', $route->methods())) {
            continue;
        }

        $uri = $route->uri();

        /* Skip routes that should NOT be in sitemap */

        if (
            // Dynamic routes such as /blog/{slug}
            str_contains($uri, '{')

            // Admin routes
            || str_starts_with($uri, 'admin')

            // API routes
            || str_starts_with($uri, 'api')

            // Excluded pages
            || in_array($uri, [
                // 'login',
                // 'register',
                'logout',
                // 'cart',
                'checkout',
                'checkout/cancel',
                'checkout/success',
                'checkout/payment',
                'robots.txt',
                'generate-sitemap',
                'auth/google/redirect',
                'auth/google/callback',
                'check-buynow-session',
                ' refunds/statistics',
                'track',
                'clear-coupon-session',
                'purchase',
                'sitemap.xml',
            ])
        ) {
            continue;
        }

        /*  Generate URL  */

        $urls[] = [
            'loc' => url($uri),
            'lastmod' => null,
        ];
    }


    /* Remove duplicate URLs */

    return collect($urls)
        ->unique('loc')
        ->values()
        ->toArray();
}

    /* Create sitemap XML files. */
    private function createSitemapFiles(array $urls): array
    {
        $files = [];

        $currentUrls = [];
        $fileNumber = 1;

        foreach ($urls as $item) {

            $testUrls = $currentUrls;
            $testUrls[] = $item;

            $xml = $this->buildUrlSetXml($testUrls);

            /*
             * If adding this URL makes the file
             * greater than 50 KB, create the
             * current file and start a new one.
             */
            if (
                count($currentUrls) > 0 &&
                strlen($xml) > self::MAX_FILE_SIZE
            ) {

                $filename = "sitemap-pages-{$fileNumber}.xml";

                File::put(
                    $this->sitemapDirectory . '/' . $filename,
                    $this->buildUrlSetXml($currentUrls)
                );

                $files[] = $filename;

                $fileNumber++;

                // Start next sitemap
                $currentUrls = [$item];

            } else {
                $currentUrls = $testUrls;
            }
        }

        /*
         * Save remaining URLs.
         */
        if (count($currentUrls) > 0) {

            $filename = "sitemap-pages-{$fileNumber}.xml";

            File::put(
                $this->sitemapDirectory . '/' . $filename,
                $this->buildUrlSetXml($currentUrls)
            );

            $files[] = $filename;
        }

        return $files;
    }

    /**
     * Build URL sitemap XML.
     */
    private function buildUrlSetXml(array $urls): string
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;

        foreach ($urls as $item) {

            $xml .= "    <url>" . PHP_EOL;

            $xml .= '        <loc>'
                . htmlspecialchars($item['loc'], ENT_XML1)
                . '</loc>'
                . PHP_EOL;

            if (!empty($item['lastmod'])) {
                $xml .= '        <lastmod>'
                    . htmlspecialchars($item['lastmod'], ENT_XML1)
                    . '</lastmod>'
                    . PHP_EOL;
            }

            $xml .= '        <changefreq>daily</changefreq>' . PHP_EOL;
            $xml .= '        <priority>0.8</priority>' . PHP_EOL;

            $xml .= "    </url>" . PHP_EOL;
        }

        $xml .= '</urlset>';

        return $xml;
    }

    /**
     * Create public/sitemap.xml
     */
    private function createSitemapIndex(array $sitemapFiles): void
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;

        $xml .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;

        foreach ($sitemapFiles as $filename) {

            $xml .= "    <sitemap>" . PHP_EOL;

            $xml .= '        <loc>'
                . htmlspecialchars(url('/sitemaps/' . $filename), ENT_XML1)
                . '</loc>'
                . PHP_EOL;

            $xml .= '        <lastmod>'
                . now()->toISOString()
                . '</lastmod>'
                . PHP_EOL;

            $xml .= "    </sitemap>" . PHP_EOL;
        }

        $xml .= '</sitemapindex>';

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
        if (!File::exists($this->sitemapDirectory)) {
            return;
        }

        foreach (File::files($this->sitemapDirectory) as $file) {
            if (str_starts_with($file->getFilename(), 'sitemap-')) {
                File::delete($file->getPathname());
            }
        }
    }
}