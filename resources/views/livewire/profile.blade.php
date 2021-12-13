<fieldset wire:ignore.self>
    <legend>System by <a href="https://github.com/KenjiWriter">@Wenzzi</a></legend>
    @if ($user)
        @if(!isset(auth()->user()->id))
            <?php $user_id = 0; ?>
            @else
            <?php $user_id = auth()->user()->id; ?>
        @endif
            <h3 align="center">Profile {{ $user->name }}</h3>
            @if ($user->profile_status == 0 and $user_id != $user->id)
                <h3>THIS PROFILE IS SET TO PRIVATE!</h3>
            @else
            @if ($user_id == $user->id)
                <b><label for="status">Private profil </label></b>
                <input type="checkbox" name="status" id="status" value="1" wire:click="setStatus"  wire:model.defer="status"> <br><br>
            @endif
            Joined in: {{ $user->created_at->toFormattedDateString() }} <br>
            @if($products && $count_all > 0)
                Announcements: {{ $count_all }} <br>
                Active announcements: <br> 
                @foreach ($products as $product)
                    @if ($product->Active == 0 && $product->user_id != $user_id)
                    <?php continue; ?>
                    @else
                    <tr>
                        <?php 
                            switch ($product['category']) {
                                case 1:
                                    $category = "Smartphones";
                                    break;
                                case 2:
                                    $category = "Tablets";
                                    break;
                                case 3:
                                    $category = "Computers";
                                    break;
                                default:
                                    $category = "Other";
                                    break;
                            }
                            if($product['First_owner'] == 1) $owner = "YES"; else $owner = "NO";
        
                        ?>
                        <a href="{{ route('product_page', $product->id) }}">
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
                        @endif
                        <td> </td>
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
