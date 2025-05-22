<div class="card shadow-sm">
    @if (session()->has('error'))
        <div class="card-body text-center py-5">
            <i class="ti ti-message-off fs-1 text-muted mb-3 d-block"></i>
            <h3 class="fw-semibold">Conversation Not Found</h3>
            <p class="text-muted">This conversation doesn't exist or you don't have access to it.</p>
            <a href="{{ route('messages') }}" class="btn btn-primary">
                <i class="ti ti-messages me-2"></i>Back to Messages
            </a>
        </div>
    @else
        <div class="card-header bg-gray py-3 border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    @if ($messages[0]->buyer == auth()->user()->id)
                        <div class="d-flex align-items-center">
                            <div class="position-relative me-2">
                                <div class="avatar-initial rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center"
                                    style="width: 40px; height: 40px;">
                                    <i class="ti ti-user"></i>
                                </div>
                                @if (Cache::has('user-is-online-' . $seller->id))
                                    <span class="position-absolute bottom-0 end-0 p-1 bg-success rounded-circle"
                                        style="width: 10px; height: 10px;"></span>
                                @else
                                    <span class="position-absolute bottom-0 end-0 p-1 bg-secondary rounded-circle"
                                        style="width: 10px; height: 10px;"></span>
                                @endif
                            </div>
                            <div>
                                <h5 class="mb-0 fw-semibold">{{ $seller->name }}</h5>
                                <small class="text-muted">
                                    @if (Cache::has('user-is-online-' . $seller->id))
                                        <span class="text-success">Online</span>
                                    @else
                                        <span class="text-muted">Offline</span>
                                    @endif
                                </small>
                            </div>
                        </div>
                    @else
                        <div class="d-flex align-items-center">
                            <div class="position-relative me-2">
                                <div class="avatar-initial rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center"
                                    style="width: 40px; height: 40px;">
                                    <i class="ti ti-user"></i>
                                </div>
                                @if (Cache::has('user-is-online-' . $buyer->id))
                                    <span class="position-absolute bottom-0 end-0 p-1 bg-success rounded-circle"
                                        style="width: 10px; height: 10px;"></span>
                                @else
                                    <span class="position-absolute bottom-0 end-0 p-1 bg-secondary rounded-circle"
                                        style="width: 10px; height: 10px;"></span>
                                @endif
                            </div>
                            <div>
                                <h5 class="mb-0 fw-semibold">{{ $buyer->name }}</h5>
                                <small class="text-muted">
                                    @if (Cache::has('user-is-online-' . $buyer->id))
                                        <span class="text-success">Online</span>
                                    @else
                                        <span class="text-muted">Offline</span>
                                    @endif
                                </small>
                            </div>
                        </div>
                    @endif
                </div>

                <div>
                    <a href="{{ route('product_page', $messages[0]->product_id) }}"
                        class="btn btn-sm btn-outline-primary d-flex align-items-center">
                        <i class="ti ti-eye me-2"></i>View Product
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body p-3 p-lg-4 chat-messages" id="chat-container" style="height: 400px; overflow-y: auto;">
            <div wire:poll.30000ms>
                @foreach ($messages as $message)
                    @if ($messages[0]->buyer == $message->sender)
                        <?php
                        $name = $buyer->name;
                        $id = $messages[0]->buyer;
                        ?>
                    @else
                        <?php
                        $name = $seller->name;
                        $id = $messages[0]->seller;
                        ?>
                    @endif

                    <div
                        class="message-bubble mb-3 {{ $message->sender == auth()->user()->id ? 'own-message' : 'other-message' }}">
                        <div
                            class="message-container d-flex {{ $message->sender == auth()->user()->id ? 'justify-content-end' : 'justify-content-start' }}">
                            @if ($message->sender != auth()->user()->id)
                                <div class="avatar-initial rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center me-2"
                                    style="width: 32px; height: 32px; flex-shrink: 0;">
                                    <i class="ti ti-user"></i>
                                </div>
                            @endif

                            <div class="message-content p-3 rounded {{ $message->sender == auth()->user()->id ? 'bg-primary text-white' : 'bg-gray' }}"
                                style="max-width: 75%;">
                                <div class="message-text">{{ $message->message }}</div>
                                <div
                                    class="message-time small {{ $message->sender == auth()->user()->id ? 'text-white-50' : 'text-muted' }} mt-1">
                                    {{ $message->created_at->format('g:i A') }}
                                </div>
                            </div>

                            @if ($message->sender == auth()->user()->id)
                                <div class="avatar-initial rounded-circle bg-primary text-white d-flex align-items-center justify-content-center ms-2"
                                    style="width: 32px; height: 32px; flex-shrink: 0;">
                                    <i class="ti ti-user"></i>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="card-footer bg-gray p-3">
            <div class="d-flex">
                <div class="input-group">
                    <textarea wire:model="body" class="form-control" rows="2" placeholder="Type your message here..."
                        style="resize: none;"></textarea>
                    <button wire:click.prevent="sendMessage" class="btn btn-primary d-flex align-items-center">
                        <i class="ti ti-send me-2"></i>Send
                    </button>
                </div>
            </div>

            @error('body')
                <div class="text-danger small mt-2">
                    <i class="ti ti-alert-circle me-1"></i>{{ $message }}
                </div>
            @enderror

            @if (session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show mt-2 mb-0 py-2" role="alert">
                    <i class="ti ti-check me-2"></i>{{ session('message') }}
                    <button type="button" class="btn-close" bg-gray-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
    @endif
</div>

<script>
    document.addEventListener('livewire:load', function() {
        // Scroll to bottom of chat on load
        const chatContainer = document.getElementById('chat-container');
        if (chatContainer) {
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }

        // Scroll to bottom on new messages
        Livewire.hook('message.processed', (message, component) => {
            if (component.fingerprint.name === 'chat') {
                if (chatContainer) {
                    chatContainer.scrollTop = chatContainer.scrollHeight;
                }
            }
        });
    });
</script>
