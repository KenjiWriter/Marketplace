<x-layout>
    @section('content')
        <div class="container-xxl fade-in">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h1 class="fw-bold mb-0">Messages</h1>
                        <span class="badge bg-primary-subtle text-primary px-3 py-2">
                            <i class="ti ti-messages me-1"></i>Conversations
                        </span>
                    </div>

                    <div class="card shadow-sm mb-4">
                        <div class="card-body p-0">
                            <ul class="nav nav-pills nav-fill mb-3 p-3 border-bottom" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button
                                        class="nav-link active fw-medium d-flex align-items-center justify-content-center"
                                        id="buying-tab" data-bs-toggle="tab" data-bs-target="#buying" type="button"
                                        role="tab" aria-controls="buying" aria-selected="true">
                                        <i class="ti ti-shopping-cart-plus me-2"></i>Buying
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fw-medium d-flex align-items-center justify-content-center"
                                        id="selling-tab" data-bs-toggle="tab" data-bs-target="#selling" type="button"
                                        role="tab" aria-controls="selling" aria-selected="false">
                                        <i class="ti ti-shopping-cart-discount me-2"></i>Selling
                                    </button>
                                </li>
                            </ul>

                            <div class="tab-content p-3">
                                <div class="tab-pane fade show active" id="buying" role="tabpanel"
                                    aria-labelledby="buying-tab">
                                    @isset($collectionBuying)
                                        <div class="list-group">
                                            @foreach ($collectionBuying as $buying)
                                                <?php
                                                $product = App\Models\product::where('id', $buying['product'])->select('name', 'Owner', 'id')->first();
                                                ?>
                                                <a href="{{ route('chat', $buying['roomId']) }}"
                                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center p-3">
                                                    <div>
                                                        <div class="d-flex align-items-center">
                                                            <i class="ti ti-message-circle me-3 fs-4 text-primary"></i>
                                                            <div>
                                                                <h5 class="mb-1 fw-semibold">{{ $product->name }}</h5>
                                                                <p class="mb-0 text-muted small">
                                                                    <i class="ti ti-user me-1"></i>Seller: {{ $product->Owner }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="text-end">
                                                        <span class="badge bg-gray-800 text-muted px-3 py-2">
                                                            <i class="ti ti-clock me-1"></i>{{ $buying['time'] }}
                                                        </span>
                                                        <i class="ti ti-chevron-right ms-2 text-muted"></i>
                                                    </div>
                                                </a>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="text-center py-5">
                                            <i class="ti ti-message-off fs-1 text-muted mb-3 d-block"></i>
                                            <h4 class="fw-semibold">No buying conversations</h4>
                                            <p class="text-muted">When you contact sellers, your conversations will appear here
                                            </p>
                                            <a href="{{ route('index') }}" class="btn btn-primary">
                                                <i class="ti ti-search me-2"></i>Browse Products
                                            </a>
                                        </div>
                                    @endisset
                                </div>

                                <div class="tab-pane fade" id="selling" role="tabpanel" aria-labelledby="selling-tab">
                                    @isset($collectionSelling)
                                        <div class="list-group">
                                            @foreach ($collectionSelling as $selling)
                                                <?php
                                                $product = App\Models\product::where('id', $selling['product'])->select('name', 'Owner', 'id')->first();
                                                ?>
                                                <a href="{{ route('chat', $selling['roomId']) }}"
                                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center p-3">
                                                    <div>
                                                        <div class="d-flex align-items-center">
                                                            <i class="ti ti-message-circle me-3 fs-4 text-primary"></i>
                                                            <div>
                                                                <h5 class="mb-1 fw-semibold">{{ $product->name }}</h5>
                                                                <p class="mb-0 text-muted small">
                                                                    <i class="ti ti-user me-1"></i>Product Inquiry
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="text-end">
                                                        <span class="badge bg-light text-muted px-3 py-2">
                                                            <i class="ti ti-clock me-1"></i>{{ $selling['time'] }}
                                                        </span>
                                                        <i class="ti ti-chevron-right ms-2 text-muted"></i>
                                                    </div>
                                                </a>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="text-center py-5">
                                            <i class="ti ti-message-off fs-1 text-muted mb-3 d-block"></i>
                                            <h4 class="fw-semibold">No selling conversations</h4>
                                            <p class="text-muted">When buyers contact you, your conversations will appear here
                                            </p>
                                            <a href="{{ route('post.add') }}" class="btn btn-primary">
                                                <i class="ti ti-plus me-2"></i>Add New Listing
                                            </a>
                                        </div>
                                    @endisset
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
</x-layout>
