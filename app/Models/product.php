<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;

    protected $dates = ['created_at', 'updated_at', 'promote_to'];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'promote_to' => 'datetime',
        'images' => 'array', // Automatycznie obsługuje konwersję JSON
    ];

    /**
     * Get the category that owns the product.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    function CheckPromoting($id)
    {
        $product = product::find($id);
        if ($product->promote_to != NULL) {
            $promote_to = $product->promote_to;
            $promoting = now()->lt($promote_to);
        } else {
            $promoting = false;
            $promote_to = NULL;
        }
        if ($promoting == false) {
            $product->promote = 0;
            $product->promote_to = $promote_to;
            $product->save();
        } else {
            $product->promote = 1;
            $product->promote_to = $promote_to;
            $product->save();
        }
    }

    function categoryName($id)
    {
        $product = product::where('id', $id)->first();

        // First try to get the category through the relationship
        if (isset($product->category_id)) {
            $categoryModel = \App\Models\Category::find($product->category_id);
            if ($categoryModel) {
                return $categoryModel->name;
            }
        }

        // Fallback to the old method if relationship doesn't work
        $categoryId = isset($product->category) ? $product->category : 4;
        switch ($categoryId) {
            case 1:
                return "Smartphones";
            case 2:
                return "Tablets";
            case 3:
                return "Computers";
            default:
                return "Other";
        }
    }

    function getImagesArray()
    {
        return $this->images ?: [];
    }

    protected $fillable = [
        'Owner',
        'user_id',
        'name',
        'description',
        'Active',
        'price',
        'images',
        'category',
        'category_id',
        'First_owner',
        'promote',
        'promote_to',
    ];
}
