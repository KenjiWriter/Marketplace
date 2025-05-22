<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\product;
use Carbon\Carbon;

class Filtr extends Component
{
    public $search, $category = null, $sort = null, $first_owner = null, $has_photo = null, $price_min = null, $price_max = null;

    public function render()
    {
        $search = $this->search;
        if (isset($this->category)) {
            if ($this->category <= 0) {
                $this->category = null;
            }
        }

        // Base query conditions
        $baseQuery = product::when($this->category, function ($query) {
            $query->where('category', $this->category);
        })
            ->when($this->first_owner, function ($query) {
                $query->where('First_owner', 1);
            })
            ->when($this->has_photo, function ($query) {
                $query->where('images', '!=', 'NULL');
            })
            ->when($this->price_min, function ($query) {
                $query->where('price', '>=', $this->price_min);
            })
            ->when($this->price_max, function ($query) {
                $query->where('price', '<=', $this->price_max);
            })
            ->where('Active', 1)
            ->where('name', 'like', "%$search%");

        // Get promoted products
        $promotedQuery = clone $baseQuery;
        $promotedProducts = $promotedQuery->where('promote', 1)
            ->whereNotNull('promote_to')
            ->where('promote_to', '>', now())
            ->when($this->sort == 1, function ($query) {
                $query->orderBy('price', 'asc');
            })
            ->when($this->sort == 2, function ($query) {
                $query->orderBy('price', 'desc');
            })
            ->when($this->sort == 3, function ($query) {
                $query->orderBy('created_at', 'asc');
            })
            ->when($this->sort == 4, function ($query) {
                $query->orderBy('created_at', 'desc');
            })
            ->orderBy('promote_to', 'desc')
            ->get();

        // Get regular products
        $regularQuery = clone $baseQuery;
        $regularProducts = $regularQuery->where(function ($query) {
            $query->where('promote', 0)
                ->orWhereNull('promote_to')
                ->orWhere('promote_to', '<=', now());
        })
            ->when($this->sort == 1, function ($query) {
                $query->orderBy('price', 'asc');
            })
            ->when($this->sort == 2, function ($query) {
                $query->orderBy('price', 'desc');
            })
            ->when($this->sort == 3, function ($query) {
                $query->orderBy('created_at', 'asc');
            })
            ->when($this->sort == 4, function ($query) {
                $query->orderBy('created_at', 'desc');
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Interleave promoted and regular products (5 promoted, 10 regular, 5 promoted, etc.)
        $mergedProducts = collect([]);
        $promotedChunks = $promotedProducts->chunk(5);
        $regularChunks = $regularProducts->chunk(10);

        $maxChunks = max($promotedChunks->count(), $regularChunks->count());

        for ($i = 0; $i < $maxChunks; $i++) {
            if (isset($promotedChunks[$i])) {
                $mergedProducts = $mergedProducts->concat($promotedChunks[$i]);
            }

            if (isset($regularChunks[$i])) {
                $mergedProducts = $mergedProducts->concat($regularChunks[$i]);
            }
        }

        // Paginate the results
        $perPage = 12;
        $page = request()->get('page', 1);
        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $mergedProducts->forPage($page, $perPage),
            $mergedProducts->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('livewire.filtr', [
            'products' => $paginator
        ]);
    }
}
