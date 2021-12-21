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
    <label for="first_owner">| First owner?</label> <input id="first_owner" type="checkbox" wire:model="first_owner">
    <label for="has_photo">| Only with photos</label> <input id="has_photo" type="checkbox" wire:model="has_photo"> <br>
    <input type="text" style="width: 30px;" wire:model="price_min" placeholder="Min">$-<input style="width: 30px;" type="text" wire:model="price_max" placeholder="Max">$<br>
    <span>Sort by</span>
    <select wire:model="sort">
        <option value="0">Don't sort</option>
        <option value="1">Price Asc</option>
        <option value="2">Price Dsc</option>
        <option value="3">Oldest</option>
        <option value="4">Newest</option>
    </select>
    <hr>
    @if ($products || $products->count() > 0)
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
            <a href="{{ route('product_page', $product->id) }}"><img src="{{ asset('storage/images/'.$img) }}" style="width: 100px; height=50px;" alt="{{ $img }}"></a> <br>
            @if ($product->promote == 1)
                <b><u style="color: gold;"><span style="color: gold;">PROMOTING</span>!</u></b>
                <a href="{{ route('product_page', $product->id) }}">
                <tr style="background-color: blue;">
                    <td>{{ $product->name }}</td>,
                    <td>Price: {{ $product->price }}$</td></a>
                    <td>| Added:  {{ $product->created_at->diffForHumans() }} by <a href="{{ route('profile', $product->user_id) }}">{{ $product->Owner }}</a></td>
                </tr><hr>
                @else
                <a href="{{ route('product_page', $product->id) }}">
                <tr>
                    <td>{{ $product->name }}</td>,
                    <td>Price: {{ $product->price }}$</td></a>
                    <td>| Added:  {{ $product->created_at->diffForHumans() }} by <a href="{{ route('profile', $product->user_id) }}">{{ $product->Owner }}</a></td>
                </tr><hr>
            @endif
        @endforeach
        {{ $products->links() }}
        @else
        <h3>NO OUTPUT</h3>
    @endif
</fieldset>
