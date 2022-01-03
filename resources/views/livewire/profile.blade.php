<fieldset wire:ignore.self>
    <legend>System by <a href="https://github.com/KenjiWriter">@Wenzzi</a></legend>
    @if ($user)
        @if(!isset(auth()->user()->id))
            <?php $user_id = 0; ?>
            @else
            <?php $user_id = auth()->user()->id; ?>
        @endif
            <div align="center">
                <h3>Profile {{ $user->name }}</h3>
                @if (Cache::has('user-is-online-'. $user->id))
                <small style="color: green;">Online</small>
                @else
                    <small style="color: red;">Offline</small>
                @endif
            </div>
            @if ($user->profile_status == 0 and $user_id != $user->id)
                <h3>THIS PROFILE IS SET TO PRIVATE!</h3>
            @else
            @if ($user_id == $user->id)
                <b><label for="status">Private profil </label></b>
                <input type="checkbox" name="status" id="status" value="1" wire:model.defer="status" wire:click.prevent="setStatus"> <br><br>
            @endif
            Joined in: {{ $user->created_at->toFormattedDateString() }} <br>
            @if($products && $count_all > 0)
                Announcements: {{ $count_all }} <br>
                Active announcements: <br> 
                @if (session()->has('error'))
                    <div>
                        <small style="color: red;">{{ session('error') }}</small>
                    </div>
                @endif
                @foreach ($products as $product)
                    <?php 
                        $product->CheckPromoting($product->id);
                        $images = $product->outPutImages($product->id);
                        if($images != NULL) {
                            $img = $images[0];
                        } else {
                            $img = 'noImg.jpg';
                        }
                    ?>
                    @if ($product->Active == 0 && $product->user_id != $user_id)
                    <?php continue; ?>
                    @else
                    <tr>
                        <a href="{{ route('product_page', $product->id) }}">
                        <img src="{{ asset('storage/images/'.$img) }}" style="width: 100px; height=50px;" alt="{{ $img }}"><br>
                        <td>{{ $product->name }}</td>,
                        <td>Price: {{ $product->price }}$</td> 
                        </a>
                        <td>| Added:  {{ $product->created_at->diffForHumans() }}</td>
                        @if ($product->Active == 0)
                            <td>| NOT ACTIVE |</td>
                        @endif
                        @if ($product->user_id == $user_id)
                            <button wire:click.prevent="delete('{{ $product->id }}')">DELETE</button>
                            <button><a href="{{ route('post.edit', $product->id) }}">EDIT</a></button>
                            <button><a href="{{ route('promote', $product->id) }}">PROMOTE</a></button>
                        @endif
                    </tr><hr>
                @endif
                @endforeach
                {{ $products->links() }}
            @endif
        @endif
    @else
        <h3>NO OUTPUT</h3>
    @endif
</fieldset>
