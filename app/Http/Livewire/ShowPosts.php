<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\product;
use App\Models\User;

class ShowPosts extends Component
{
    public $user_id;
    public function render()
    {
        $products = product::where('user_id',$this->user_id)->get();
        return view('livewire.show-posts', [
            'products' => $products
        ]);
    }
}
