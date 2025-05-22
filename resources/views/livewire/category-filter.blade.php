<div>
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-gray py-3">
            <h5 class="mb-0 fw-semibold d-flex align-items-center">
                <i class="ti ti-category me-2 text-primary"></i>Categories
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="list-group list-group-flush">
                @foreach ($parentCategories as $category)
                    <button type="button"
                        class="list-group-item list-group-item-action d-flex align-items-center {{ $selectedCategoryId == $category->id ? 'active' : '' }}"
                        wire:click="categorySelected(1, {{ $category->id }})">
                        <i class="{{ $category->icon ?? 'ti ti-folder' }} me-2"></i>
                        {{ $category->name }}
                        @if ($category->children->count() > 0)
                            <i class="ti ti-chevron-right ms-auto"></i>
                        @endif
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    @if (count($childCategories) > 0)
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-gray py-3">
                <h5 class="mb-0 fw-semibold d-flex align-items-center">
                    <i class="ti ti-folder me-2 text-primary"></i>Subcategories
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @foreach ($childCategories as $category)
                        <button type="button"
                            class="list-group-item list-group-item-action d-flex align-items-center {{ $selectedCategoryId == $category->id ? 'active' : '' }}"
                            wire:click="categorySelected(2, {{ $category->id }})">
                            <i class="{{ $category->icon ?? 'ti ti-folder' }} me-2"></i>
                            {{ $category->name }}
                            @if ($category->children->count() > 0)
                                <i class="ti ti-chevron-right ms-auto"></i>
                            @endif
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    @if (count($grandchildCategories) > 0)
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-gray py-3">
                <h5 class="mb-0 fw-semibold d-flex align-items-center">
                    <i class="ti ti-folder me-2 text-primary"></i>Subcategories
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @foreach ($grandchildCategories as $category)
                        <button type="button"
                            class="list-group-item list-group-item-action d-flex align-items-center {{ $selectedCategoryId == $category->id ? 'active' : '' }}"
                            wire:click="categorySelected(3, {{ $category->id }})">
                            <i class="{{ $category->icon ?? 'ti ti-folder' }} me-2"></i>
                            {{ $category->name }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
