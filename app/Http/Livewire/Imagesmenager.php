<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\product;
use File;

class Imagesmenager extends Component
{
    public $images, $product;

    public function remove($key)
    {
        if(File::exists(public_path('storage/images/'.$this->images[$key]))){
            File::delete(public_path('storage/images/'.$this->images[$key]));
        }else{
            session()->flash('error', 'The image was not found. '.$this->images[$key]);
        }
        $product = product::find($this->product->id);
        $delated_images = json_decode($product->images, true);
        unset($delated_images[$key]);
        $images = json_encode($delated_images);
        $product->images = $images;
        $product->save();
        session()->flash('success', 'Image successfully removed.');
        $this->render();
    }

    public function render()
    {
        $images = $this->product->outPutImages($this->product->id);
        $this->images = $images;
        return view('livewire.imagesmenager');
    }
}
