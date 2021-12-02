<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\product;
use Carbon\Carbon;

class Filtr extends Component
{
    public $search;
    public $category = null;
    public $first_owner = null;
    public $price_min = null;
    public $price_max = null;

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
        ->when($this->price_min, function($query) {
            $query->where('price', '>=', $this->price_min);
        })
        ->when($this->price_max, function($query) {
            $query->where('price', '<=', $this->price_max);
        })
        ->where('Active',1)
        ->where('name','like',"%$search%")
        ->simplePaginate(10);
        return view('livewire.filtr', [
            'products' => $products
        ]);
    }
}
