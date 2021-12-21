<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;

    protected $dates = ['created_at', 'updated_at', 'promote_to'];

    function CheckPromoting($id) 
    {
        $product = product::find($id);
        if($product->promote_to != NULL) {
            $promote_to = $product->promote_to;
            $promoting = now()->lt($promote_to);
        } else {
            $promoting = false;
            $promote_to = NULL;
        }
        if($promoting == false) {
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
        $product = product::where('id', $id)->select('category')->first();
        switch ($product->category) {
            case 1:
                $category = "Smartphones";
                break;
            case 2:
                $category = "Tablets";
                break;
            case 3:
                $category = "Computers";
                break;
            default:
                $category = "Other";
                break;
        }
        return $category;
    }

    function outPutImages($id)
    {
        $product = product::where('id', $id)->select('images')->first();
        $images = json_decode($product->images, true);
        return $images;
    }

    protected $fillable = [
        'Owner',
        'user_id',
        'name',
        'Active',
        'price',
        'images',
        'category',
        'First_owner',
        'promote',
        'promote_to',
    ];
}
