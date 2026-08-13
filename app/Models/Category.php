<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'title',
        'about',
        'slug',
        'description',
        'parent_id',
        'image',
        'public_id',
        'is_active',
        'is_home',
        'home_position',
        'meta_title',
        'keywords',
        'tags',
        'meta_description',
        'schema_markup',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'is_active' => 1,
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            $category->slug = $category->slug ?? Str::slug($category->name);
        });

        static::updating(function ($category) {
            if ($category->isDirty('name')) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    /**
     * Get all of the posts for the Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'category_post');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function latestProduct()
    {
        return $this->hasOne(Product::class)
            ->where('status', 'active')
            ->whereHas('variants')
            ->latest('id'); // or 'created_at'
    }
    
    public function latestProducts()
{
    return $this->hasOne(Product::class, 'category_id', 'id')
        ->where('status', 'active')   // or ->where('status', 1)
        ->latest('id');
}

    public function latestProductWithImage()
    {
        return $this->hasOne(Product::class)
            ->where('is_active', 1)
            ->whereHas('variants')
            ->with('images')
            ->latest('id');
    }
    // In app/Models/Category.php

/**
 * Get the best image for this category (variant image > product image > category image)
 */
public function getBestImage($variantImage = null, $productImage = null)
{
    // Priority 1: Variant image (passed from controller)
    if ($variantImage) {
        return $variantImage;
    }
    
    // Priority 2: Product image
    if ($productImage) {
        return $productImage;
    }
    
    // Priority 3: Category image
    if ($this->image) {
        return $this->image;
    }
    
    // Priority 4: Default placeholder
    return asset('assets/images/placeholder.jpg');
}

/**
 * Get optimized Cloudinary image URL
 */
public function getOptimizedImageUrl($imageUrl, $width = 200, $height = 200)
{
    if (!$imageUrl) {
        return asset('assets/images/placeholder.jpg');
    }
    
    // Check if it's a Cloudinary URL
    if (strpos($imageUrl, 'cloudinary.com') !== false && strpos($imageUrl, 'upload/') !== false) {
        // Extract the path after 'upload/'
        $parts = explode('upload/', $imageUrl);
        if (isset($parts[1])) {
            // Check if there's a version number
            $path = $parts[1];
            if (strpos($path, 'v') === 0 && strpos($path, '/') !== false) {
                // Has version number like v123456/
                $versionParts = explode('/', $path, 2);
                if (isset($versionParts[1])) {
                    return $parts[0] . "upload/w_{$width},h_{$height},c_fill,f_auto,q_auto/" . $versionParts[1];
                }
            }
            return $parts[0] . "upload/w_{$width},h_{$height},c_fill,f_auto,q_auto/" . $path;
        }
    }
    
    return $imageUrl;
}
}
