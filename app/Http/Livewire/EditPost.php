<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\product;
use Auth;

class EditPost extends Component
{
    public $post_id;
    public function edit()
    {

    }

    public function render()
    {
        $product = product::where('id', $this->post_id)->first();
        if(auth()->user()->id != $product->user_id) {
            dd('THIS IS NOT OK');
        }
        return view('livewire.edit-post', [
            'product' => $product
        ]);
    }
}
