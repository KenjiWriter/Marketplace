<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\product;
use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Facades\Session;

class Filtr extends Component
{
    public $search, $category_id = null, $sort = null, $first_owner = null, $has_photo = null, $price_min = null, $price_max = null;

    protected $listeners = ['categoryChanged'];

    public function categoryChanged($categoryId)
    {
        $this->category_id = $categoryId;
    }

    public function render()
    {
        $search = $this->search;
        $categoryIds = $this->category_id ? $this->getAllChildCategoryIds($this->category_id) : [];
        
        $productsQuery = Product::query()
            ->when($this->category_id, function ($query) use ($categoryIds) {
                $query->whereIn('category_id', $categoryIds);
            })
            ->when($this->first_owner, function ($query) {
                $query->where('First_owner', 1);
            })
            ->when($this->has_photo, function ($query) {
                $query->where('images', '!=', 'NULL');
            })
            ->when($this->price_min, function ($query) {
                $query->where('price', '>=', $this->price_min);
            })
            ->when($this->price_max, function ($query) {
                $query->where('price', '<=', $this->price_max);
            })
            ->where('Active', 1)
            ->where('name', 'like', "%$search%")
            ->select(['id', 'name', 'description', 'price', 'images', 'promote', 'promote_to', 'user_id', 'category_id', 'created_at'])
            ->with(['category:id,name,slug,icon']);
            
        // Dodaj sortowanie i promocje jako case when w sql
        $productsQuery->orderByRaw('CASE WHEN promote = 1 AND promote_to > NOW() THEN 1 ELSE 0 END DESC');
        
        // Dodaj pozostałe sortowanie
        switch($this->sort) {
            case 1: 
                $productsQuery->orderBy('price', 'asc');
                break;
            case 2:
                $productsQuery->orderBy('price', 'desc');
                break;
            case 3:
                $productsQuery->orderBy('created_at', 'asc');
                break;
            case 4:
                $productsQuery->orderBy('created_at', 'desc');
                break;
            default:
                $productsQuery->orderBy('created_at', 'desc');
        }
                
        // Paginacja
        $perPage = 12;
        $products = $productsQuery->paginate($perPage);
        
        $selectedCategory = $this->category_id ? Category::find($this->category_id) : null;
        
        return view('livewire.filtr', [
            'products' => $products,
            'selectedCategory' => $selectedCategory
        ]);
    }

    private function getAllChildCategoryIds($categoryId)
    {
        // Start with the current category ID
        $categoryIds = [$categoryId];

        // Get immediate children
        $childCategories = Category::where('parent_id', $categoryId)->get();

        // Recursively get all descendants
        foreach ($childCategories as $childCategory) {
            $categoryIds = array_merge($categoryIds, $this->getAllChildCategoryIds($childCategory->id));
        }

        return $categoryIds;
    }
}
