<div>
    <div class="mb-4">
        <div class="card bg-light">
            <div class="card-body">
                <h6 class="fw-semibold mb-3">Add New Images</h6>
                <div class="mb-3">
                    <input type="file" class="form-control" id="file" wire:model="photos" multiple accept="image/*">
                    <div class="form-text">
                        <i class="ti ti-info-circle me-1"></i>Select multiple images to upload
                    </div>
                </div>

                <div class="d-flex align-items-center">
                    <button class="btn btn-primary d-flex align-items-center" wire:click="addPhotos"
                        wire:loading.attr="disabled">
                        <i class="ti ti-upload me-2" wire:loading.remove wire:target="addPhotos"></i>
                        <i class="ti ti-loader ti-spin me-2" wire:loading wire:target="addPhotos"></i>
                        <span wire:loading.remove wire:target="addPhotos">Upload Images</span>
                        <span wire:loading wire:target="addPhotos">Uploading...</span>
                    </button>

                    <div wire:loading wire:target="photos" class="ms-3 text-primary">
                        <i class="ti ti-loader ti-spin me-1"></i>Preparing files...
                    </div>
                </div>

                @if (session()->has('success_add'))
                    <div class="alert alert-success alert-dismissible fade show mt-3 mb-0" role="alert">
                        <i class="ti ti-check me-2"></i>{{ session('success_add') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
            <i class="ti ti-alert-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
            <i class="ti ti-check me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (isset($images) && count($images) > 0)
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="fw-semibold mb-0">Current Images</h6>
            <div class="text-muted small">
                <i class="ti ti-drag-drop me-1"></i>Drag to reorder
            </div>
        </div>

        <div class="row g-3" id="image-sortable" wire:sortable="updateImageOrder">
            @foreach ($imageOrder as $key)
                @if (isset($images[$key]))
                    <div class="col-6 col-md-4 col-lg-3" wire:key="image-{{ $key }}"
                        wire:sortable.item="{{ $key }}">
                        <div class="card h-100 position-relative">
                            <div wire:sortable.handle class="cursor-move">
                                <img src="{{ asset('storage/images/' . $images[$key]) }}" class="card-img-top"
                                    alt="Product Image {{ $key + 1 }}" style="height: 160px; object-fit: cover;">
                            </div>

                            <div class="card-footer p-2 d-flex justify-content-between align-items-center bg-light">
                                <span class="badge bg-primary-subtle text-primary">
                                    <i class="ti ti-photo me-1"></i>Image {{ $key + 1 }}
                                </span>

                                <button type="button" class="btn btn-sm btn-outline-danger"
                                    wire:click="remove({{ $key }})" title="Remove Image">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @else
        <div class="card border-dashed">
            <div class="card-body text-center py-4">
                <i class="ti ti-photo-off fs-1 text-muted mb-3 d-block"></i>
                <h5 class="fw-medium">No Images Added</h5>
                <p class="text-muted">Upload images to showcase your product from different angles.</p>
            </div>
        </div>
    @endif
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/gh/livewire/sortable@v0.x.x/dist/livewire-sortable.js"></script>
    <style>
        .cursor-move {
            cursor: move;
        }

        .border-dashed {
            border-style: dashed;
            border-width: 2px;
            border-color: var(--bs-border-color);
        }
    </style>
@endpush
