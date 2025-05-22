@if (!Auth::guest())
    <div>
        @if ($existingRoomId)
            <div class="text-center py-3">
                <i class="ti ti-messages fs-1 text-primary mb-3 d-block"></i>
                <h4 class="fw-semibold">{{ __('product_page.existing_conversation') }}</h4>
                <p class="text-muted mb-4">{{ __('product_page.continue_conversation') }}</p>
                <a href="{{ route('chat', $existingRoomId) }}" class="btn btn-primary d-inline-flex align-items-center">
                    <i class="ti ti-message-circle me-2"></i>{{ __('product_page.open_conversation') }}
                </a>
            </div>
        @else
            <form wire:submit.prevent="sendMessage">
                <div class="mb-3">
                    <label for="messageBody" class="form-label fw-medium">{{ __('product_page.your_message') }}</label>
                    <textarea id="messageBody" wire:model="body" class="form-control" rows="4"
                        placeholder="{{ __('product_page.message_placeholder') }}"></textarea>
                    @error('body')
                        <div class="text-danger small mt-1">
                            <i class="ti ti-alert-circle me-1"></i>{{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary d-flex align-items-center justify-content-center">
                        <i class="ti ti-send me-2"></i>{{ __('product_page.send_message') }}
                    </button>
                </div>

                @if (session()->has('message'))
                    <div class="alert alert-success alert-dismissible fade show mt-3 mb-0" role="alert">
                        <i class="ti ti-check me-2"></i>{{ session('message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </form>
        @endif
    </div>
@else
    <div class="text-center py-4">
        <i class="ti ti-lock fs-1 text-muted mb-3 d-block"></i>
        <h4 class="fw-semibold">{{ __('product_page.login_required') }}</h4>
        <p class="text-muted mb-4">{{ __('product_page.login_to_contact') }}</p>
        <a href="{{ route('auth') }}" class="btn btn-primary d-inline-flex align-items-center">
            <i class="ti ti-login me-2"></i>{{ __('marketplace.login_register') }}
        </a>
    </div>
@endif
