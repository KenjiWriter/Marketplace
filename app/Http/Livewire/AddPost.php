<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\product;
use Auth;

class AddPost extends Component
{
    public $name = null, $first_owner = null, $category = null, $price = null;

    public function add()
    {
        $validatedDate = $this->validate([
            'name' => 'required',
            'category' => 'required',
            'price' => 'required',
        ]);
        if(isset($this->first_owner)) {
            $first_owner = 1;
        } else {
            $first_owner = 0;
        }
        $productData = array('Active' => 1, 'name' => $this->name,'user_id' => auth()->user()->id, 'First_owner' => $first_owner, 'Owner' => auth()->user()->name, 'price' => $this->price, 'category' => $this->category);
        product::create($productData);
        session()->flash('message', "Successfuly added new announcement.");
    }

    public function render()
    {
        return view('livewire.add-post');
    }
}
