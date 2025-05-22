<div class="container-xxl fade-in">
    <div class="row g-4">
        <!-- Filter Sidebar -->
        <div class="col-lg-3 mb-4">
            <!-- Category Filter Component -->
            @livewire('category-filter')

            <div class="card shadow-sm">
                <div class="card-header bg-gray py-3">
                    <h5 class="mb-0 fw-semibold d-flex align-items-center">
                        <i class="ti ti-adjustments me-2 text-primary"></i>{{ __('filtr.filters') }}
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Search -->
                    <div class="mb-4">
                        <label class="form-label fw-medium">{{ __('filtr.search') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-gray border-end-0">
                                <i class="ti ti-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" wire:model="search"
                                placeholder="{{ __('filtr.search_placeholder') }}">
                        </div>
                    </div>

                    <!-- Price Range -->
                    <div class="mb-4">
                        <label class="form-label fw-medium d-flex align-items-center">
                            <i class="ti ti-currency-dollar me-2 text-primary"></i>{{ __('filtr.price_range') }}
                        </label>
                        <div class="row g-2">
                            <div class="col-6">
                                <div class="input-group">
                                    <span class="input-group-text bg-gray">$</span>
                                    <input type="number" min="0" class="form-control" wire:model="price_min"
                                        placeholder="{{ __('filtr.min') }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group">
                                    <span class="input-group-text bg-gray">$</span>
                                    <input type="number" min="0" class="form-control" wire:model="price_max"
                                        placeholder="{{ __('filtr.max') }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Checkboxes -->
                    <div class="mb-4">
                        <label class="form-label fw-medium d-flex align-items-center">
                            <i class="ti ti-filter me-2 text-primary"></i>{{ __('filtr.additional_filters') }}
                        </label>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="firstOwner" wire:model="first_owner">
                            <label class="form-check-label" for="firstOwner">{{ __('filtr.first_owner_only') }}</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="hasPhoto" wire:model="has_photo">
                            <label class="form-check-label" for="hasPhoto">{{ __('filtr.with_photos_only') }}</label>
                        </div>
                    </div>

                    <!-- Sort -->
                    <div class="mb-3">
                        <label for="sort" class="form-label fw-medium d-flex align-items-center">
                            <i class="ti ti-sort-ascending me-2 text-primary"></i>{{ __('filtr.sort_by') }}
                        </label>
                        <select class="form-select" id="sort" wire:model="sort">
                            <option value="">{{ __('filtr.relevance') }}</option>
                            <option value="1">{{ __('filtr.price_low_high') }}</option>
                            <option value="2">{{ __('filtr.price_high_low') }}</option>
                            <option value="3">{{ __('filtr.oldest') }}</option>
                            <option value="4">{{ __('filtr.newest') }}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="col-lg-9">
            @if ($selectedCategory)
                <div class="mb-4">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            @if ($selectedCategory->parent && $selectedCategory->parent->parent)
                                <li class="breadcrumb-item"><a href="#"
                                        wire:click.prevent="$emitTo('category-filter', 'categorySelected', 1, {{ $selectedCategory->parent->parent->id }})">{{ $selectedCategory->parent->parent->name }}</a>
                                </li>
                                <li class="breadcrumb-item"><a href="#"
                                        wire:click.prevent="$emitTo('category-filter', 'categorySelected', 2, {{ $selectedCategory->parent->id }})">{{ $selectedCategory->parent->name }}123</a>
                                </li>
                                <li class="breadcrumb-item active">{{ __('categories.' . $selectedCategory->name) }}
                                </li>
                            @elseif($selectedCategory->parent)
                                <li class="breadcrumb-item"><a href="#"
                                        wire:click.prevent="$emitTo('category-filter', 'categorySelected', 1, {{ $selectedCategory->parent->id }})">{{ $selectedCategory->parent->name }}</a>
                                </li>
                                <li class="breadcrumb-item active">{{ __('categories.' . $selectedCategory->name) }}
                                </li>
                            @else
                                <li class="breadcrumb-item active">{{ __('categories.' . $selectedCategory->name) }}
                                </li>
                            @endif
                        </ol>
                    </nav>
                </div>
            @endif

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
                            <div
                                class="card product-card h-100 {{ $product->promote == 1 && now()->lt($product->promote_to) ? 'promoted' : '' }}">
                                @if ($product->promote == 1 && now()->lt($product->promote_to))
                                    <div class="badge-promoted">
                                        <i class="ti ti-star-filled me-1"></i>{{ __('filtr.featured') }}
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
                        <h3 class="fw-semibold">{{ __('filtr.no_products') }}</h3>
                        <p class="text-muted">{{ __('filtr.try_adjusting') }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
