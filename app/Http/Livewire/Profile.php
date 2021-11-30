<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\product;

class Profile extends Component
{
    public $user_id;
    public function render()
    {
        $user = User::where('id', $this->user_id)->first();
        $products = product::where('user_id',$this->user_id)->get();
        return view('livewire.profile',[
            'user' => $user,
            'products' => $products
        ]);
    }
}
