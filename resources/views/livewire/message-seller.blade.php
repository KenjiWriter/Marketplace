@if (!Auth::guest())
    <div>
        <h2>Message seller</h2>
        <textarea wire:model="body" cols="30" rows="4"></textarea>
        @error('body')<br> <small style="color: red;">{{ $message }}</small>@enderror
        @if (session()->has('message'))
            <div>
                {{ session('message') }}
            </div>
        @endif
        <br>
        <button name="sendMessage" id="sendMessage" wire:click.prevent="sendMessage">Send message</button>
    </div>
    @else
    <h2><a href="{{ route('auth') }}">Login in</a> to be able to message to seller</h2>
@endif