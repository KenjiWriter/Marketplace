<?php


namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\product;
use Livewire\WithFileUploads;
use File;

class Imagesmenager extends Component
{
    use WithFileUploads;
    public $images = [];
    public $product;
    public $photos;
    public $imageOrder = [];

    protected $listeners = ['updateImageOrder'];

    public function updateImageOrder($orderedIds)
    {
        // Get the current images
        $product = product::find($this->product->id);
        $currentImages = json_decode($product->images, true) ?: [];

        // Create new ordered array
        $newOrder = [];
        foreach ($orderedIds as $index) {
            if (isset($currentImages[$index])) {
                $newOrder[] = $currentImages[$index];
            }
        }

        // Save the new order
        $product->images = json_encode($newOrder);
        $product->save();

        session()->flash('success', 'Image order updated successfully.');
        $this->render();
    }

    public function addPhotos()
    {
        $product = product::find($this->product->id);
        $DB_images = json_decode($product->images, true) ?: [];

        foreach ($this->photos as $key => $photo) {
            $original_name = strtolower(trim($photo->getClientOriginalName()));
            $file_name = time() . auth()->user()->id . rand(0, 999) . $key . '.' . $photo->getClientOriginalExtension();

            // Store in public disk
            $photo->storeAs('images', $file_name, 'public');

            $DB_images[] = $file_name;
        }

        $product->images = json_encode($DB_images);
        $product->save();
        session()->flash('success_add', 'Image successfully added.');
        $this->photos = null;
        $this->render();
    }

    public function remove($key)
    {
        $imagePath = storage_path('app/public/images/' . $this->images[$key]);

        if (File::exists($imagePath)) {
            File::delete($imagePath);
        } else {
            session()->flash('error', 'The image was not found. ' . $this->images[$key]);
            return;
        }

        $product = product::find($this->product->id);
        $delated_images = json_decode($product->images, true) ?: [];
        unset($delated_images[$key]);
        $delated_images = array_values($delated_images); // Re-index array
        $images = json_encode($delated_images);
        $product->images = $images;
        $product->save();
        session()->flash('success', 'Image successfully removed.');
        $this->render();
    }

    public function render()
    {
        $this->images = $this->product->outPutImages($this->product->id) ?: [];
        $this->imageOrder = range(0, count($this->images) - 1);

        return view('livewire.imagesmenager');
    }
}
