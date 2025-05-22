<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;

class CategoryFilter extends Component
{
    public $selectedCategoryId = null;
    public $parentCategories = [];
    public $childCategories = [];
    public $grandchildCategories = [];

    protected $listeners = ['categorySelected'];

    public function mount()
    {
        $this->parentCategories = Category::getRootCategories();
    }

    public function categorySelected($level, $categoryId)
    {
        if ($level == 1) {
            $this->selectedCategoryId = $categoryId;
            $this->childCategories = Category::getSubcategories($categoryId);
            $this->grandchildCategories = [];
            $this->emit('categoryChanged', $categoryId);
        } elseif ($level == 2) {
            $this->selectedCategoryId = $categoryId;
            $this->grandchildCategories = Category::getSubcategories($categoryId);
            $this->emit('categoryChanged', $categoryId);
        } else {
            $this->selectedCategoryId = $categoryId;
            $this->emit('categoryChanged', $categoryId);
        }
    }

    public function render()
    {
        return view('livewire.category-filter');
    }
}
