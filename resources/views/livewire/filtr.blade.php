<fieldset>
    <legend>System by <a href="https://github.com/KenjiWriter">@Wenzzi</a></legend>
    @if (!Auth::guest())
            Hi {{ auth()->user()->name }}! <a href="{{ route('post.add') }}">Add announcement</a>, <a href="user/post/{{ auth()->user()->id }}">My announcement</a>
            <br>
    @endif
    <input type="text" wire:model="search" placeholder="Search...">
    <select wire:model="category">
        <option value="0">All Category</option>
        <option value="1">Phones</option>
        <option value="2">Tablets</option>
        <option value="3">Computers</option>
    </select>
    <label for="first_owner">| First owner?</label> <input id="first_owner" type="checkbox" wire:model="first_owner"> <br>
    <input type="text" style="width: 30px;" wire:model="price_min" placeholder="Min">$-<input style="width: 30px;" type="text" wire:model="price_max" placeholder="Max">$
    <hr>
    @if ($products || $products->count() > 0)
        @foreach ($products as $product)
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
                <td>{{ $product->name }}</td>,
                <td>{{ $category }}</td>,
                <td>First owner: {{ $owner }}</td>,
                <td>Price: {{ $product->price }}$</td> 
                <td>| Added:  {{ $product->created_at->diffForHumans() }} by <a href="{{ route('profile', $product->user_id) }}">{{ $product->Owner }}</a></td>
            </tr><hr>
        @endforeach
        {{ $products->links() }}
        @else
        <h3>NO OUTPUT</h3>
    @endif
</fieldset>
