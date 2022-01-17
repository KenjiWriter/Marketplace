<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\product;
use Livewire\WithFileUploads;
use Auth;

class AddPost extends Component
{
    use WithFileUploads;
    public $name = null, $description = null, $first_owner = null, $category = null, $price = null, $photos = [];
    public function add()
    {
        $validatedDate = $this->validate([
            'name' => 'required|min:3',
            'category' => 'required',
            'price' => 'required',
            'description' => 'max:500',
        ]);
        if(isset($this->first_owner)) {
            $first_owner = 1;
        } else {
            $first_owner = 0;
        }
        if(count($this->photos) > 0) {
            foreach ($this->photos as $key => $photo) {
                $original_name = strtolower(trim($photo->getClientOriginalName()));
                $file_name = time().auth()->user()->id.rand(0,999).$key.'.'.$photo->getClientOriginalExtension();
                $photo->storeAs('images',$file_name);
                $fileArray[] = $file_name;
            }
            $images = json_encode($fileArray);
        } else {
            $images = NULL;
        }
        $productData = array('Active' => 1, 'name' => $this->name, 'description' => $this->description, 'user_id' => auth()->user()->id, 'First_owner' => $first_owner,
                             'Owner' => auth()->user()->name, 'price' => $this->price, 'category' => $this->category, 'images' => $images);
        product::create($productData);
        return redirect()->route('index')->with('global_message', 'Successfuly added new announcement.');
    }

    public function render()
    {
        return view('livewire.add-post');
    }
}
