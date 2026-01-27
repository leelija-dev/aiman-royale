<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComponentDetails extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'component_details';
    protected $primaryKey = 'component_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'page_id',
        'page_details_id',
        'title',
        'description',
    ];

    // In ComponentDetail model
public function page()
{
    return $this->belongsTo(Page::class);
}

public function pageDetails()
{
    return $this->belongsTo(PageDetails::class);
}
    /**
     * Get the page that this component detail belongs to.
     */
    // public function page()
    // {
    //     return $this->belongsTo(Page::class, 'page_id');
    // }

    // /**
    //  * Get the page details that this component detail belongs to.
    //  */
    // public function pageDetails()
    // {
    //     return $this->belongsTo(PageDetails::class, 'page_details_id');
    // }
}

