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
        'display_order',
        'parent_id',
        'level'
    ];

    /**
     * Get the parent category
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Get direct children categories
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')
            ->where('active', true)
            ->orderBy('display_order')
            ->orderBy('name');
    }

    /**
     * Get the products for this category
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get root categories (top level)
     */
    public static function getRootCategories()
    {
        return self::where('active', true)
            ->whereNull('parent_id')
            ->orderBy('display_order')
            ->orderBy('name')
            ->get();
    }

    /**
     * Get all active subcategories for a specific parent
     */
    public static function getSubcategories($parentId)
    {
        return self::where('active', true)
            ->where('parent_id', $parentId)
            ->orderBy('display_order')
            ->orderBy('name')
            ->get();
    }

    /**
     * Get full path of category names
     */
    public function getFullPathAttribute()
    {
        $path = [$this->name];
        $category = $this;

        while ($category->parent) {
            $category = $category->parent;
            array_unshift($path, $category->name);
        }

        return implode(' > ', $path);
    }
}
