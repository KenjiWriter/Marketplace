<div>
    <div align="center">
        <h2>Chat with @if ($messages[0]->buyer == auth()->user()->id)
            {{ $seller->name }}
            @else
            {{ $buyer->name }}
        @endif</h2>
        <small><a href="{{ route("product_page", $messages[0]->product_id) }}">{{ $product->name }}</a></small>
    </div>
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
            <div @if ($message->sender == auth()->user()->id) align="right" @else align="left" @endif  title="[{{ $message->created_at }}]">
                <a href="{{ route('profile', $id) }}">{{ $name }}</a>: {{ $message->message }}
            </div>
        @endforeach
    </div>

    <div align="center">
        <textarea wire:model="body" cols="30" rows="3"></textarea>
        @error('body')<br> <small style="color: red;">{{ $message }}</small>@enderror
        @if (session()->has('message'))
            <div>
                {{ session('message') }}
            </div>
        @endif
        <br>
        <button wire:click.prevent="sendMessage">Send</button>
    </div>
</div>
