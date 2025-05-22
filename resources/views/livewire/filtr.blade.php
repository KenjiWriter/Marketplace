<div class="container-xxl fade-in">
    <div class="row g-4">
        <!-- Filter Sidebar -->
        <div class="col-lg-3 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-gray py-3">
                    <h5 class="mb-0 fw-semibold d-flex align-items-center">
                        <i class="ti ti-adjustments me-2 text-primary"></i>Filters
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Search -->
                    <div class="mb-4">
                        <label class="form-label fw-medium">Search</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="ti ti-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" wire:model="search"
                                placeholder="Search products...">
                        </div>
                    </div>

                    <!-- Price Range -->
                    <div class="mb-4">
                        <label class="form-label fw-medium d-flex align-items-center">
                            <i class="ti ti-currency-dollar me-2 text-primary"></i>Price Range
                        </label>
                        <div class="row g-2">
                            <div class="col-6">
                                <div class="input-group">
                                    <span class="input-group-text bg-white">$</span>
                                    <input type="number" min="0" class="form-control" wire:model="price_min"
                                        placeholder="Min">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group">
                                    <span class="input-group-text bg-white">$</span>
                                    <input type="number" min="0" class="form-control" wire:model="price_max"
                                        placeholder="Max">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Category -->
                    <div class="mb-4">
                        <label for="category" class="form-label fw-medium d-flex align-items-center">
                            <i class="ti ti-category me-2 text-primary"></i>Category
                        </label>
                        <select class="form-select" id="category" wire:model="category">
                            <option value="">All Categories</option>
                            <option value="1">Electronics</option>
                            <option value="2">Vehicles</option>
                            <option value="3">Computers</option>
                            <option value="4">Other</option>
                        </select>
                    </div>

                    <!-- Checkboxes -->
                    <div class="mb-4">
                        <label class="form-label fw-medium d-flex align-items-center">
                            <i class="ti ti-filter me-2 text-primary"></i>Additional Filters
                        </label>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="firstOwner" wire:model="first_owner">
                            <label class="form-check-label" for="firstOwner">First Owner Only</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="hasPhoto" wire:model="has_photo">
                            <label class="form-check-label" for="hasPhoto">With Photos Only</label>
                        </div>
                    </div>

                    <!-- Sort -->
                    <div class="mb-3">
                        <label for="sort" class="form-label fw-medium d-flex align-items-center">
                            <i class="ti ti-sort-ascending me-2 text-primary"></i>Sort By
                        </label>
                        <select class="form-select" id="sort" wire:model="sort">
                            <option value="">Relevance</option>
                            <option value="1">Price: Low to High</option>
                            <option value="2">Price: High to Low</option>
                            <option value="3">Oldest</option>
                            <option value="4">Newest</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="col-lg-9">
            @if (count($products) > 0)
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                    @foreach ($products as $product)
                        <?php
                        $product->CheckPromoting($product->id);
                        $images = $product->outPutImages($product->id);
                        $img = $images[0] ?? 'noImg.jpg';
                        $description = $product->description ?? 'No item description';
                        ?>
                        <div class="col">
                            <div class="card product-card h-100">
                                @if (now()->lt($product->promote_to ?? now()))
                                    <div class="badge-promoted">
                                        <i class="ti ti-star-filled me-1"></i>Featured
                                    </div>
                                @endif

                                <a href="{{ route('product_page', $product->id) }}" class="position-relative">
                                    <img src="{{ asset('storage/images/' . $img) }}" class="card-img-top"
                                        alt="{{ $product->name }}">
                                </a>

                                <div class="card-body d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <a href="{{ route('product_page', $product->id) }}" class="product-title">
                                            {{ $product->name }}
                                        </a>
                                        <div class="product-price">${{ $product->price }}</div>
                                    </div>

                                    <p class="product-description mb-4">{{ Str::limit($description, 75) }}</p>

                                    <div class="product-meta mt-auto">
                                        <div>
                                            <i class="ti ti-clock me-1"></i>{{ $product->created_at->diffForHumans() }}
                                        </div>
                                        <div>
                                            <a href="{{ route('profile', $product->user_id) }}"
                                                class="text-decoration-none">
                                                <i class="ti ti-user me-1"></i>{{ $product->Owner }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $products->links() }}
                </div>
            @else
                <div class="card shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="ti ti-search-off fs-1 text-muted mb-3 d-block"></i>
                        <h3 class="fw-semibold">No products found</h3>
                        <p class="text-muted">Try adjusting your search or filter criteria</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
