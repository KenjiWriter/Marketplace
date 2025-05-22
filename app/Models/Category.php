<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'icon',
        'description',
        'active',
        'display_order'
    ];

    /**
     * Get the products for the category.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get active categories ordered by display_order
     */
    public static function getActive()
    {
        return self::where('active', true)
            ->orderBy('display_order')
            ->orderBy('name')
            ->get();
    }
}
