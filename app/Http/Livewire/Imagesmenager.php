<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\product;
use Livewire\WithFileUploads;
use File;

class Imagesmenager extends Component
{
    use WithFileUploads;
    public $images, $product, $photos;

    public function addPhotos()
    {
        $product = product::find($this->product->id);
        $DB_images = json_decode($product->images, true);
        foreach ($this->photos as $key => $photo) {
            $original_name = strtolower(trim($photo->getClientOriginalName()));
            $file_name = time().auth()->user()->id.rand(0,999).$key.'.'.$photo->getClientOriginalExtension();
            $photo->storeAs('images',$file_name);
            $fileArray[] = $file_name;
            if($DB_images != NULL) {
                $DB_images[] = $file_name;
                $images = json_encode($DB_images);
            } else {
                $images = json_encode($fileArray);
            }
        }
        $product->images = $images;
        $product->save();
        session()->flash('success_add', 'Image successfully added.');
        $this->render();
    }

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
