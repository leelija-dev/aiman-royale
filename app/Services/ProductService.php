<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductService
{
    /**
     * Cache duration in seconds
     */
    const CACHE_DURATION = 3600; // 1 hour
    
    /**
     * Get homepage products with caching
     */
    public function homepageProducts(): Collection
    {
        return Cache::store('redis')->remember('homepage_products', 3600, function () {
            return Product::with(['category', 'images'])
                ->where('status', 'active')
                ->latest()
                ->take(20)
                ->get();
        });
    }
    
    /**
     * Get all products with caching
     */
    public function getAllProducts($perPage = 12): LengthAwarePaginator
    {
        $cacheKey = 'products_all_' . $perPage . '_page_' . request('page', 1);
        
        return Cache::store('redis')->remember($cacheKey, self::CACHE_DURATION, function() use ($perPage) {
            return Product::with(['category', 'occasions', 'images'])
                ->where('status', 'active')
                ->orderBy('created_at', 'desc')
                ->paginate($perPage);
        });
    }
    
    /**
     * Get product by ID with caching
     */
    public function getProductById($id): ?Product
    {
        $cacheKey = 'product_' . $id;
        
        return Cache::store('redis')->remember($cacheKey, self::CACHE_DURATION, function() use ($id) {
            return Product::with(['category', 'occasions', 'images', 'specifications'])
                ->where('id', $id)
                ->where('status', 'active')
                ->first();
        });
    }
    
    /**
     * Get product by slug with caching
     */
    public function getProductBySlug($slug): ?Product
    {
        $cacheKey = 'product_slug_' . $slug;
        
        return Cache::store('redis')->remember($cacheKey, self::CACHE_DURATION, function() use ($slug) {
            return Product::with(['category', 'occasions', 'images', 'specifications'])
                ->where('slug', $slug)
                ->where('status', 'active')
                ->first();
        });
    }
    
    /**
     * Get products by category with caching
     */
    public function getProductsByCategory($categoryId, $perPage = 12): LengthAwarePaginator
    {
        $cacheKey = 'products_category_' . $categoryId . '_' . $perPage . '_page_' . request('page', 1);
        
        return Cache::store('redis')->remember($cacheKey, self::CACHE_DURATION, function() use ($categoryId, $perPage) {
            return Product::with(['category', 'occasions', 'images'])
                ->where('category_id', $categoryId)
                ->where('status', 'active')
                ->orderBy('created_at', 'desc')
                ->paginate($perPage);
        });
    }
    
    /**
     * Get products by occasion with caching
     */
    public function getProductsByOccasion($occasionId, $perPage = 12): LengthAwarePaginator
    {
        $cacheKey = 'products_occasion_' . $occasionId . '_' . $perPage . '_page_' . request('page', 1);
        
        return Cache::store('redis')->remember($cacheKey, self::CACHE_DURATION, function() use ($occasionId, $perPage) {
            return Product::with(['category', 'occasions', 'images'])
                ->whereHas('occasions', function($query) use ($occasionId) {
                    $query->where('occasions.id', $occasionId);
                })
                ->where('status', 'active')
                ->orderBy('created_at', 'desc')
                ->paginate($perPage);
        });
    }
    
    /**
     * Get products by category and occasion with caching
     */
    public function getProductsByCategoryAndOccasion($categoryId, $occasionId, $perPage = 12): LengthAwarePaginator
    {
        $cacheKey = 'products_category_' . $categoryId . '_occasion_' . $occasionId . '_' . $perPage . '_page_' . request('page', 1);
        
        return Cache::store('redis')->remember($cacheKey, self::CACHE_DURATION, function() use ($categoryId, $occasionId, $perPage) {
            return Product::with(['category', 'occasions', 'images'])
                ->where('category_id', $categoryId)
                ->whereHas('occasions', function($query) use ($occasionId) {
                    $query->where('occasions.id', $occasionId);
                })
                ->where('status', 'active')
                ->orderBy('created_at', 'desc')
                ->paginate($perPage);
        });
    }
    
    /**
     * Search products with caching
     */
    public function searchProducts($query, $perPage = 12): LengthAwarePaginator
    {
        $cacheKey = 'products_search_' . md5($query) . '_' . $perPage . '_page_' . request('page', 1);
        
        return Cache::store('redis')->remember($cacheKey, self::CACHE_DURATION, function() use ($query, $perPage) {
            return Product::with(['category', 'occasions', 'images'])
                ->where('status', 'active')
                ->where(function($q) use ($query) {
                    $q->where('name', 'LIKE', '%' . $query . '%')
                      ->orWhere('description', 'LIKE', '%' . $query . '%')
                      ->orWhere('sku', 'LIKE', '%' . $query . '%');
                })
                ->orderBy('created_at', 'desc')
                ->paginate($perPage);
        });
    }
    
    /**
     * Get featured products with caching
     */
    public function getFeaturedProducts($limit = 8): Collection
    {
        $cacheKey = 'products_featured_' . $limit;
        
        return Cache::store('redis')->remember($cacheKey, self::CACHE_DURATION, function() use ($limit) {
            return Product::with(['category', 'occasions', 'images'])
                ->where('status', 'active')
                ->where('is_featured', true)
                ->orderBy('created_at', 'desc')
                ->limit($limit)
                ->get();
        });
    }
    
    /**
     * Get new arrivals with caching
     */
    public function getNewArrivals($limit = 8): Collection
    {
        $cacheKey = 'products_new_arrivals_' . $limit;
        
        return Cache::store('redis')->remember($cacheKey, self::CACHE_DURATION, function() use ($limit) {
            return Product::with(['category', 'occasions', 'images'])
                ->where('status', 'active')
                ->orderBy('created_at', 'desc')
                ->limit($limit)
                ->get();
        });
    }
    
    /**
     * Get related products with caching
     */
    public function getRelatedProducts($productId, $limit = 4): Collection
    {
        $cacheKey = 'products_related_' . $productId . '_' . $limit;
        
        return Cache::store('redis')->remember($cacheKey, self::CACHE_DURATION, function() use ($productId, $limit) {
            $product = Product::find($productId);
            
            if (!$product) {
                return collect();
            }
            
            return Product::with(['category', 'occasions', 'images'])
                ->where('id', '!=', $productId)
                ->where('category_id', $product->category_id)
                ->where('status', 'active')
                ->orderBy('created_at', 'desc')
                ->limit($limit)
                ->get();
        });
    }
    
    /**
     * Get product specifications with caching
     */
    public function getProductSpecifications($productId): Collection
    {
        $cacheKey = 'product_specifications_' . $productId;
        
        return Cache::store('redis')->remember($cacheKey, self::CACHE_DURATION, function() use ($productId) {
            $product = Product::find($productId);
            
            if (!$product) {
                return collect();
            }
            
            return $product->specifications()->with('specification')->get();
        });
    }
    
    /**
     * Get product parts with caching
     */
    public function getProductParts($productId): Collection
    {
        $cacheKey = 'product_parts_' . $productId;
        
        return Cache::store('redis')->remember($cacheKey, self::CACHE_DURATION, function() use ($productId) {
            $product = Product::find($productId);
            
            if (!$product) {
                return collect();
            }
            
            return $product->parts()->orderBy('created_at', 'asc')->get();
        });
    }
    
    /**
     * Clear product cache
     */
    public function clearProductCache($productId = null): void
    {
        $redis = Redis::connection();
        
        if ($productId) {
            // Clear specific product cache
            $redis->del('product_' . $productId);
            $redis->del('product_slug_' . $productId);
            $redis->del('product_specifications_' . $productId);
            $redis->del('product_parts_' . $productId);
            $redis->del('products_related_' . $productId);
        } else {
            // Clear all product-related caches
            $productKeys = $redis->keys('product_*');
            if (!empty($productKeys)) {
                $redis->del($productKeys);
            }
            
            $productsKeys = $redis->keys('products_*');
            if (!empty($productsKeys)) {
                $redis->del($productsKeys);
            }
            
            // Clear homepage products cache
            $redis->del('homepage_products');
        }
    }
    
    /**
     * Warm up product cache
     */
    public function warmUpProductCache(): void
    {
        // Cache homepage products
        $this->homepageProducts();
        
        // Cache featured products
        $this->getFeaturedProducts();
        
        // Cache new arrivals
        $this->getNewArrivals();
        
        // Cache all products (first page)
        $this->getAllProducts();
        
        // Cache categories with product counts
        $categories = \App\Models\Category::withCount('products')->get();
        foreach ($categories as $category) {
            $this->getProductsByCategory($category->id);
        }
        
        // Cache occasions with product counts
        $occasions = \App\Models\Occasion::withCount('products')->get();
        foreach ($occasions as $occasion) {
            $this->getProductsByOccasion($occasion->id);
        }
    }
    
    /**
     * Get cache statistics
     */
    public function getCacheStats(): array
    {
        $redis = Redis::connection();
        
        $productKeys = $redis->keys('product_*');
        $productsKeys = $redis->keys('products_*');
        $homepageCache = $redis->exists('homepage_products');
        
        return [
            'product_cache_count' => count($productKeys),
            'products_cache_count' => count($productsKeys),
            'homepage_cache_exists' => $homepageCache,
            'total_cache_keys' => $redis->dbsize(),
            'memory_usage' => $redis->info('memory')['used_memory_human'] ?? 'N/A',
            'cache_duration' => self::CACHE_DURATION . ' seconds'
        ];
    }
}
