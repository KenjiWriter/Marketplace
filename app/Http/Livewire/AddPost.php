<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\product;
use App\Models\Category;
use Livewire\WithFileUploads;
use Illuminate\Support\Collection;
use Auth;

class AddPost extends Component
{
    use WithFileUploads;
    public $name = null, $description = null, $first_owner = null, $category_id = null, $price = null, $photos = [];
    public $categories = [];
    public $photoOrder = []; // Track the order of photos

    protected $listeners = ['updatePhotoOrder'];

    public function mount()
    {
        $this->categories = Category::where('active', true)
            ->orderBy('display_order')
            ->orderBy('name')
            ->get();
    }

    // Remove a specific photo before submitting
    public function removePhoto($index)
    {
        // Normalize photos to array
        $photos = is_array($this->photos) ? $this->photos : ($this->photos instanceof Collection ? $this->photos->toArray() : []);

        if (isset($photos[$index])) {
            unset($photos[$index]);
            // Re-index the array
            $this->photos = array_values($photos);

            // Reset photo order to match new array indices
            $this->photoOrder = range(0, count($this->photos) - 1);
        }
    }

    // Update the order of photos
    public function updatePhotoOrder($orderedIds)
    {
        // Make sure we only store valid indices
        $validOrderedIds = [];

        // Normalize photos to array
        $photos = is_array($this->photos) ? $this->photos : ($this->photos instanceof Collection ? $this->photos->toArray() : []);

        foreach ($orderedIds as $id) {
            // Extract the actual index value if $id is an array or object
            $index = is_array($id) ? ($id['value'] ?? null) : $id;

            // If we have a valid index and the photo exists
            if (is_numeric($index) && isset($photos[$index])) {
                $validOrderedIds[] = $index;
            }
        }

        $this->photoOrder = $validOrderedIds;
    }

    public function add()
    {
        $validatedData = $this->validate([
            'name' => 'required|min:3',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'description' => 'max:500',
        ]);

        $first_owner = $this->first_owner ? 1 : 0;

        $fileArray = [];
        if (count($this->photos) > 0) {
            // Convert to array to ensure proper handling
            $photos = is_array($this->photos) ? $this->photos : $this->photos->toArray();

            // Apply the ordering if it exists
            $orderedPhotos = $photos;
            if (!empty($this->photoOrder)) {
                $orderedPhotos = [];
                foreach ($this->photoOrder as $index) {
                    if (isset($photos[$index])) {
                        $orderedPhotos[] = $photos[$index];
                    }
                }
            }

            foreach ($orderedPhotos as $key => $photo) {
                $original_name = strtolower(trim($photo->getClientOriginalName()));
                $file_name = time() . auth()->user()->id . rand(0, 999) . $key . '.' . $photo->getClientOriginalExtension();

                // Store in public disk
                $photo->storeAs('images', $file_name, 'public');

                $fileArray[] = $file_name;
            }
            $images = json_encode($fileArray);
        } else {
            $images = NULL;
        }

        $productData = [
            'Active' => 1,
            'name' => $this->name,
            'description' => $this->description,
            'user_id' => auth()->user()->id,
            'First_owner' => $first_owner,
            'Owner' => auth()->user()->name,
            'price' => $this->price,
            'category_id' => $this->category_id,
            'category' => $this->category_id,
            'images' => $images
        ];

        product::create($productData);

        return redirect()->route('index')->with('global_message', 'Successfully added new listing.');
    }

    public function render()
    {
        // Convert photos to array to ensure consistent handling
        $photos = is_array($this->photos) ? $this->photos : ($this->photos instanceof Collection ? $this->photos->toArray() : $this->photos);

        // Initialize photo order if empty
        if (empty($this->photoOrder) && !empty($photos)) {
            $this->photoOrder = range(0, count($photos) - 1);
        }

        return view('livewire.add-post');
    }
}
