<x-layout>
    @section('content')
        <div class="container-xxl fade-in">
            @if (isset($product))
                <?php
                $category = $product->categoryName($product->id);
                $owner = $product->First_owner == 1 ? __('product_page.yes') : __('product_page.no');
                $images = $product->outPutImages($product->id);
                $img = $images ?? ['noImg.jpg'];
                ?>

                <div class="row g-4">
                    <!-- Product Images -->
                    <div class="col-lg-6 mb-4">
                        <div class="card shadow-sm">
                            <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner rounded-top">
                                    @if (!empty($images))
                                        @foreach ($images as $key => $image)
                                            <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                                                <img src="{{ asset('storage/images/' . $image) }}" class="d-block w-100"
                                                    style="height: 400px; object-fit: contain;" alt="{{ $product->name }}">
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="carousel-item active">
                                            <img src="{{ asset('storage/images/noImg.jpg') }}" class="d-block w-100"
                                                style="height: 400px; object-fit: contain;"
                                                alt="{{ __('product_page.no_image') }}">
                                        </div>
                                    @endif
                                </div>

                                @if (!empty($images) && count($images) > 1)
                                    <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel"
                                        data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">{{ __('product_page.previous') }}</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#productCarousel"
                                        data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">{{ __('product_page.next') }}</span>
                                    </button>
                                @endif
                            </div>

                            @if (!empty($images) && count($images) > 1)
                                <div class="card-body">
                                    <div class="row row-cols-5 g-2">
                                        @foreach ($images as $key => $image)
                                            <div class="col">
                                                <img src="{{ asset('storage/images/' . $image) }}" class="img-thumbnail"
                                                    style="height: 60px; object-fit: cover; cursor: pointer;"
                                                    data-bs-target="#productCarousel" data-bs-slide-to="{{ $key }}"
                                                    alt="{{ $product->name }}">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Product Details -->
                    <div class="col-lg-6">
                        <div class="card shadow-sm mb-4">
                            <div class="card-body">
                                <h2 class="mb-3 fw-semibold">{{ $product->name }}</h2>

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h3 class="text-primary fw-bold mb-0">${{ $product->price }}</h3>
                                    <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill">
                                        <i class="ti ti-tag me-1"></i>{{ __('categories.' . $category) }}
                                    </span>
                                </div>

                                <hr>

                                <div class="mb-4">
                                    <h5 class="text-muted mb-3 fw-semibold d-flex align-items-center">
                                        <i
                                            class="ti ti-file-description me-2 text-primary"></i>{{ __('product_page.description') }}
                                    </h5>
                                    <p>{{ $product->description ?? __('product_page.no_description') }}</p>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="ti ti-certificate me-2 text-primary"></i>
                                                <span class="text-muted">{{ __('product_page.first_owner') }}</span>
                                            </div>
                                            <span class="fw-medium">{{ $owner }}</span>
                                        </div>
                                        <div>
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="ti ti-calendar me-2 text-primary"></i>
                                                <span class="text-muted">{{ __('product_page.listed_on') }}</span>
                                            </div>
                                            <span class="fw-medium">{{ $product->created_at->format('M d, Y') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div>
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="ti ti-user me-2 text-primary"></i>
                                                <span class="text-muted">{{ __('product_page.seller') }}</span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <a href="{{ route('profile', $product->user_id) }}"
                                                    class="fw-medium text-decoration-none">
                                                    {{ $product->Owner }}
                                                </a>
                                                @if (Cache::has('user-is-online-' . $product->user_id))
                                                    <span
                                                        class="badge bg-success-subtle text-success ms-2 px-2 py-1 rounded-pill">
                                                        <i
                                                            class="ti ti-circle-filled me-1 small"></i>{{ __('product_page.online') }}
                                                    </span>
                                                @else
                                                    <span
                                                        class="badge bg-secondary-subtle text-secondary ms-2 px-2 py-1 rounded-pill">
                                                        <i
                                                            class="ti ti-circle me-1 small"></i>{{ __('product_page.offline') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Message Form -->
                        @if (Auth::check() && Auth::id() != $product->user_id)
                            <div class="card shadow-sm">
                                <div class="card-header bg-gray py-3">
                                    <h5 class="mb-0 fw-semibold d-flex align-items-center">
                                        <i
                                            class="ti ti-message-circle me-2 text-primary"></i>{{ __('product_page.contact_seller') }}
                                    </h5>
                                </div>
                                <div class="card-body">
                                    @livewire('message-seller', ['product_id' => $product->id, 'product_seller' => $product->user_id])
                                </div>
                            </div>
                        @elseif(Auth::check() && Auth::id() == $product->user_id)
                            <div class="card shadow-sm">
                                <div class="card-header bg-gray py-3">
                                    <h5 class="mb-0 fw-semibold d-flex align-items-center">
                                        <i
                                            class="ti ti-edit me-2 text-primary"></i>{{ __('product_page.listing_management') }}
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex flex-column gap-2">
                                        <a href="{{ route('post.edit', $product->id) }}"
                                            class="btn btn-primary d-flex align-items-center justify-content-center">
                                            <i class="ti ti-edit me-2"></i>{{ __('product_page.edit_listing') }}
                                        </a>
                                        <a href="{{ route('promote', $product->id) }}"
                                            class="btn btn-success d-flex align-items-center justify-content-center">
                                            <i class="ti ti-speakerphone me-2"></i>{{ __('product_page.promote_listing') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="card shadow-sm text-center py-5">
                    <div class="card-body">
                        <i class="ti ti-alert-circle fs-1 text-danger mb-3 d-block"></i>
                        <h3 class="fw-semibold">{{ __('product_page.product_not_found') }}</h3>
                        <p class="text-muted">{{ __('product_page.product_not_found_description') }}</p>
                        <a href="{{ route('index') }}" class="btn btn-primary mt-3 d-inline-flex align-items-center">
                            <i class="ti ti-home me-2"></i>{{ __('product_page.back_to_home') }}
                        </a>
                    </div>
                </div>
            @endif
        </div>
    @endsection
</x-layout>
