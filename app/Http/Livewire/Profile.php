<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\product;

class Profile extends Component
{
    public $user_id;
    public $count_all;

    public function delete($id)
    {
        product::find($id)->delete();
    }

    public function render()
    {
        $user = User::where('id', $this->user_id)->first();
        $products = product::where('user_id',$this->user_id)->get();
        $count_all = $products->count();
        $this->count_all = $count_all;
        $products = collect($products)->where('Active',1);
        return view('livewire.profile',[
            'user' => $user,
            'products' => $products
        ]);
    }
}
