<div class="container-xxl fade-in py-3">
    @if ($user)
        <div class="row g-4">
            <!-- Profile Sidebar -->
            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-body text-center py-4">
                        <div class="position-relative d-inline-block mb-3">
                            @isset($user->avatar)
                                <img src="{{ url($user->avatar) }}" class="rounded-circle" width="120" height="120"
                                    alt="{{ $user->name }}">
                            @else
                                <div class="avatar-initial rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center mx-auto"
                                    style="width: 120px; height: 120px;">
                                    <i class="ti ti-user fs-1"></i>
                                </div>
                            @endisset
                        </div>

                        <h3 class="fw-bold mb-1">{{ $user->name }}</h3>
                        <p class="text-muted mb-3">
                            <i class="ti ti-calendar me-1"></i>Joined {{ $user->created_at->toFormattedDateString() }}
                        </p>

                        @if ($user_id == $user->id)
                            <div class="form-check form-switch d-flex justify-content-center align-items-center mb-3">
                                <input class="form-check-input me-2" type="checkbox" role="switch" id="status"
                                    value="1" wire:model.defer="status" wire:click.prevent="setStatus">
                                <label class="form-check-label fw-medium" for="status">
                                    <i class="ti ti-{{ $status ? 'lock' : 'world' }} me-1"></i>
                                    {{ $status ? 'Private Profile' : 'Public Profile' }}
                                </label>
                            </div>

                            <div class="d-grid gap-2">
                                <a href="#"
                                    class="btn btn-outline-primary d-flex align-items-center justify-content-center">
                                    <i class="ti ti-edit me-2"></i>Edit Profile
                                </a>
                                <a href="{{ route('post.add') }}"
                                    class="btn btn-primary d-flex align-items-center justify-content-center">
                                    <i class="ti ti-plus me-2"></i>Add New Listing
                                </a>
                            </div>
                        @else
                            <div class="d-grid">
                                <button class="btn btn-primary d-flex align-items-center justify-content-center">
                                    <i class="ti ti-message-circle me-2"></i>Message
                                </button>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Stats Card -->
                <div class="card shadow-sm mt-3">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-semibold d-flex align-items-center">
                            <i class="ti ti-chart-bar me-2 text-primary"></i>Stats
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-0 text-center">
                            <div class="col-4 border-end">
                                <div class="p-3">
                                    <h5 class="fw-bold mb-1">{{ $count_all ?? 0 }}</h5>
                                    <p class="text-muted small mb-0">Listings</p>
                                </div>
                            </div>
                            <div class="col-4 border-end">
                                <div class="p-3">
                                    <h5 class="fw-bold mb-1">{{ $user->created_at->diffInMonths(now()) }}</h5>
                                    <p class="text-muted small mb-0">Months</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="p-3">
                                    <h5 class="fw-bold mb-1">
                                        {{ $user->last_seen }}</h5>
                                    <p class="text-muted small mb-0">Last Active</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User's Listings -->
            <div class="col-lg-8">
                @if ($user->profile_status == 0 && $user_id != $user->id)
                    <div class="card shadow-sm text-center py-5">
                        <div class="card-body">
                            <i class="ti ti-lock fs-1 text-muted mb-3 d-block"></i>
                            <h3 class="fw-semibold">Private Profile</h3>
                            <p class="text-muted">This user has set their profile to private.</p>
                        </div>
                    </div>
                @else
                    <div class="card shadow-sm">
                        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-semibold d-flex align-items-center">
                                <i class="ti ti-shopping-cart me-2 text-primary"></i>Listings
                            </h5>

                            @if ($products && $count_all > 0)
                                <span class="badge bg-primary-subtle text-primary px-3 py-2">
                                    Total: {{ $count_all }}
                                </span>
                            @endif
                        </div>

                        <div class="card-body p-0">
                            @if (session()->has('error'))
                                <div class="alert alert-danger m-3" role="alert">
                                    <i class="ti ti-alert-circle me-2"></i>{{ session('error') }}
                                </div>
                            @endif

                            @if ($products && $count_all > 0)
                                <div class="list-group list-group-flush">
                                    @foreach ($products as $product)
                                        <?php
                                        $product->CheckPromoting($product->id);
                                        $images = $product->outPutImages($product->id);
                                        $img = $images[0] ?? 'noImg.jpg';
                                        ?>

                                        @if (!($product->Active == 0 && $product->user_id != $user_id))
                                            <div class="list-group-item p-3">
                                                <div class="row g-3 align-items-center">
                                                    <div class="col-md-2 col-sm-3">
                                                        <a href="{{ route('product_page', $product->id) }}"
                                                            class="d-block">
                                                            <img src="{{ asset('storage/images/' . $img) }}"
                                                                class="img-fluid rounded" alt="{{ $product->name }}">
                                                        </a>
                                                    </div>
                                                    <div class="col-md-7 col-sm-6">
                                                        <a href="{{ route('product_page', $product->id) }}"
                                                            class="text-decoration-none">
                                                            <h5 class="mb-1 product-title">{{ $product->name }}</h5>
                                                        </a>
                                                        <div class="d-flex align-items-center mb-2">
                                                            <span class="badge bg-primary-subtle text-primary me-2">
                                                                ${{ $product->price }}
                                                            </span>
                                                            <span class="text-muted small">
                                                                <i
                                                                    class="ti ti-calendar me-1"></i>{{ $product->created_at->diffForHumans() }}
                                                            </span>
                                                        </div>

                                                        @if ($product->Active == 0)
                                                            <span class="badge bg-danger-subtle text-danger">
                                                                <i class="ti ti-eye-off me-1"></i>Not Active
                                                            </span>
                                                        @endif

                                                        @if (now()->lt($product->promote_to ?? now()))
                                                            <span class="badge bg-warning-subtle text-warning">
                                                                <i class="ti ti-star me-1"></i>Promoted
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-3 col-sm-3 text-md-end mt-md-0 mt-2">
                                                        @if ($product->user_id == $user_id)
                                                            <div class="btn-group" role="group">
                                                                <button type="button"
                                                                    class="btn btn-sm btn-outline-danger"
                                                                    wire:click.prevent="delete('{{ $product->id }}')"
                                                                    data-bs-toggle="tooltip" title="Delete">
                                                                    <i class="ti ti-trash"></i>
                                                                </button>
                                                                <a href="{{ route('post.edit', $product->id) }}"
                                                                    class="btn btn-sm btn-outline-primary"
                                                                    data-bs-toggle="tooltip" title="Edit">
                                                                    <i class="ti ti-edit"></i>
                                                                </a>
                                                                <a href="{{ route('promote', $product->id) }}"
                                                                    class="btn btn-sm btn-outline-success"
                                                                    data-bs-toggle="tooltip" title="Promote">
                                                                    <i class="ti ti-speakerphone"></i>
                                                                </a>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                                <div class="d-flex justify-content-center my-3">
                                    {{ $products->links() }}
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <i class="ti ti-shopping-cart-off fs-1 text-muted mb-3 d-block"></i>
                                    <h4 class="fw-semibold">No Listings Yet</h4>
                                    <p class="text-muted">This user hasn't posted any listings yet.</p>
                                    @if ($user_id == $user->id)
                                        <a href="{{ route('post.add') }}" class="btn btn-primary">
                                            <i class="ti ti-plus me-2"></i>Add New Listing
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="card shadow-sm text-center py-5">
            <div class="card-body">
                <i class="ti ti-user-off fs-1 text-muted mb-3 d-block"></i>
                <h3 class="fw-semibold">User Not Found</h3>
                <p class="text-muted">The user you're looking for doesn't exist or has been removed.</p>
                <a href="{{ route('index') }}" class="btn btn-primary">
                    <i class="ti ti-home me-2"></i>Back to Home
                </a>
            </div>
        </div>
    @endif
</div>

<!-- Initialize tooltips -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });

    // Reinitialize tooltips after Livewire updates
    document.addEventListener('livewire:load', function() {
        Livewire.hook('message.processed', (message, component) => {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll(
                '[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
        });
    });
</script>
