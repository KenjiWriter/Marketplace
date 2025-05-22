<div>
    <div class="container-xxl fade-in py-3">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-gray py-3">
                        <h5 class="mb-0 fw-semibold d-flex align-items-center">
                            <i class="ti ti-plus-circle me-2 text-primary"></i>Add New Listing
                        </h5>
                    </div>

                    <div class="card-body p-4">
                        @if (session()->has('message'))
                            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                                <i class="ti ti-check me-2"></i>{{ session('message') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session()->has('error'))
                            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                                <i class="ti ti-alert-circle me-2"></i>{{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <form>
                            <div class="mb-3">
                                <label for="name" class="form-label fw-medium">Listing Title</label>
                                <input class="form-control" type="text" wire:model="name" id="name"
                                    placeholder="What are you selling?">
                                @error('name')
                                    <div class="text-danger small mt-1">
                                        <i class="ti ti-alert-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="category" class="form-label fw-medium">Category</label>
                                    <select class="form-select" wire:model="category_id" id="category">
                                        <option value="">Select a category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="text-danger small mt-1">
                                            <i class="ti ti-alert-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="price" class="form-label fw-medium">Price ($)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-gray">$</span>
                                        <input type="number" id="price" class="form-control" wire:model="price"
                                            placeholder="Enter price" min="0" step="0.01">
                                    </div>
                                    @error('price')
                                        <div class="text-danger small mt-1">
                                            <i class="ti ti-alert-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label fw-medium">Description</label>
                                <textarea class="form-control" id="description" wire:model="description" rows="5"
                                    placeholder="Describe your item. Include information like condition, features, and reason for selling."></textarea>
                                @error('description')
                                    <div class="text-danger small mt-1">
                                        <i class="ti ti-alert-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                                <div class="form-text">
                                    <i class="ti ti-info-circle me-1"></i>Maximum 500 characters
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" wire:model="first_owner"
                                        id="firstOwner">
                                    <label class="form-check-label" for="firstOwner">
                                        I am the first owner of this item
                                    </label>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="photos" class="form-label fw-medium">
                                    <i class="ti ti-photo me-1 text-primary"></i>Upload Photos
                                </label>
                                <input type="file" class="form-control" id="photos" wire:model="photos" multiple
                                    accept="image/*">

                                @error('photos')
                                    <div class="text-danger small mt-1">
                                        <i class="ti ti-alert-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror

                                <div class="form-text">
                                    <i class="ti ti-info-circle me-1"></i>You can upload multiple photos
                                </div>

                                <div wire:loading wire:target="photos" class="mt-2">
                                    <i class="ti ti-loader ti-spin me-2"></i>Uploading...
                                </div>

                                @if ($photos && count($photos) > 0)
                                    <div class="mt-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="mb-0 fw-semibold">Preview Images</h6>
                                            <div class="text-muted small">
                                                <i class="ti ti-drag-drop me-1"></i>Drag to reorder
                                            </div>
                                        </div>
                                        <div id="photo-sortable" class="row g-2" wire:sortable="updatePhotoOrder">
                                            @foreach ($photoOrder as $position => $index)
                                                @php
                                                    // Get the actual photo by index if it exists
                                                    $photo = null;
                                                    if (is_array($photos) && isset($photos[$index])) {
                                                        $photo = $photos[$index];
                                                    } elseif (is_object($photos) && isset($photos[$index])) {
                                                        $photo = $photos[$index];
                                                    }
                                                @endphp

                                                @if ($photo)
                                                    <div class="col-4 col-md-3 col-lg-2"
                                                        wire:key="photo-{{ $index }}"
                                                        wire:sortable.item="{{ $index }}">
                                                        <div class="card h-100 position-relative">
                                                            <div wire:sortable.handle class="cursor-move">
                                                                <span
                                                                    class="position-absolute top-0 start-0 m-1 badge bg-primary-subtle text-primary"
                                                                    style="z-index: 2;">
                                                                    {{ $position + 1 }}
                                                                </span>

                                                                <img src="{{ $photo->temporaryUrl() }}"
                                                                    class="card-img-top" alt="Preview"
                                                                    style="height: 100px; object-fit: cover;">
                                                            </div>

                                                            <!-- Keep the rest of your button code -->

                                                            <div class="card-footer p-1 text-center bg-light">
                                                                <small class="text-muted">{{ $position + 1 }}</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="d-grid">
                                <button wire:click.prevent="add"
                                    class="btn btn-primary py-2 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-plus me-2"></i>Create Listing
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/gh/livewire/sortable@v0.x.x/dist/livewire-sortable.js"></script>
@endpush
