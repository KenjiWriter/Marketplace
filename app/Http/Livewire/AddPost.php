<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\product;
use Livewire\WithFileUploads;
use Auth;

class AddPost extends Component
{
    use WithFileUploads;
    public $name = null, $first_owner = null, $category = null, $price = null, $photos = [];
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
        foreach ($this->photos as $key => $photo) {
            $original_name = strtolower(trim($photo->getClientOriginalName()));
            $file_name = time().auth()->user()->id.rand(0,999).$key.'.'.$photo->getClientOriginalExtension();
            $photo->storeAs('images',$file_name);
            $fileArray[] = $file_name;
        }
        $images = json_encode($fileArray);
        $productData = array('Active' => 1, 'name' => $this->name,'user_id' => auth()->user()->id, 'First_owner' => $first_owner,
                             'Owner' => auth()->user()->name, 'price' => $this->price, 'category' => $this->category, 'images' => $images);
        product::create($productData);
        session()->flash('message', "Successfuly added new announcement.");
    }

    public function render()
    {
        return view('livewire.add-post');
    }
}
