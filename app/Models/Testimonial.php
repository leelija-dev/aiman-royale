<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Testimonial extends Model
{   
    use SoftDeletes;
    protected $table='testimonial';
    protected $fillable=[
        'page_id',
        'name',
        'designation',
        'message',
        'image',
        'status'
    ];
    protected $dates = ['deleted_at'];

    public function scopeActive($q) { return $q->where($this->getTable().'.status', 1); }
    // Usage: Testimonial::forServiceSlug($slug)->active()->get();

    /**
     * Relationship: A testimonial belongs to a page
     * Keys are explicit since `pages` primary key is `page_id`.
     */
    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class, 'page_id', 'page_id');
    }

    /**
     * Scope: Filter testimonials by service slug via a subquery on pages/services
     * This avoids joining the base table which could inadvertently affect result sets.
     */
    public function scopeForServiceSlug($query, string $slug)
    {
        $table = $this->getTable();
        return $query->whereIn($table.'.page_id', function ($sub) use ($slug) {
            $sub->select('pages.page_id')
                ->from('pages')
                ->join('services', 'pages.service_id', '=', 'services.id')
                ->where('services.slug', $slug);
        });
    }

    /**
     * Order newest first
     */
    public function scopeNewestFirst($query)
    {
        // return $query->orderBy($this->getTable().'.created_at', 'desc');
        return $query->orderByDesc('id');
    }
}
