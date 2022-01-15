<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\product;
use Carbon\Carbon;

class Filtr extends Component
{
    public $search, $category = null, $sort = null, $first_owner = null, $has_photo = null, $price_min = null, $price_max = null;

    public function render()
    {
        $search = $this->search;
        if(isset($this->category)) {
            if($this->category <= 0) {
                $this->category === null;
            }
        }
        $products = product::when($this->category, function($query) {
            $query->where('category',$this->category);
        })
        ->when($this->first_owner, function($query) {
            $query->where('First_owner',1);
        })
        ->when($this->has_photo, function($query) {
            $query->where('images','!=','NULL');
        })
        ->when($this->price_min, function($query) {
            $query->where('price', '>=', $this->price_min);
        })
        ->when($this->price_max, function($query) {
            $query->where('price', '<=', $this->price_max);
        })
        ->where('Active',1)
        ->where('name','like',"%$search%")
        ->orderBy('promote', 'desc')
        ->when($this->sort == 1, function($query) {
            $query->orderBy('price', 'asc');
        })
        ->when($this->sort == 2, function($query) {
            $query->orderBy('price', 'desc');
        })
        ->when($this->sort == 3, function($query) {
            $query->orderBy('created_at', 'asc');
        })
        ->when($this->sort == 4, function($query) {
            $query->orderBy('created_at', 'desc');
        })
        ->paginate(12);
        return view('livewire.filtr', [
            'products' => $products
        ]);
    }
}
