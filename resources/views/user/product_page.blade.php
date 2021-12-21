<x-layout>
    @section('content')
    <fieldset>
        <legend>System by <a href="https://github.com/KenjiWriter">@Wenzzi</a></legend>
        @if (isset($product))
            <?php 
                $category = $product->categoryName($product->id);
                if($product['First_owner'] == 1) $owner = "YES"; else $owner = "NO";
                $images = $product->outPutImages($product->id);
                if($images == NULL) {
                    $img = 'noImg.jpg';
                }
            ?>
            <tr>
                @if (!isset($img))
                    @foreach ($images as $image)
                        <img style="width: 150px; height=100px;" src="{{ asset('storage/images/'.$image) }}" alt="{{ $image }}">
                    @endforeach
                    @else
                    <img style="width: 150px; height=100px;" src="{{ asset('storage/images/'.$img) }}" alt="{{ $img }}">
                @endif <br>
                <td><label>Product name: {{ $product->name }}</label></td><br>
                <td><label>Category: {{ $category }}</label></td><br>
                <td><label>First owner: {{ $owner }}</label></td><br>
                <td><label>Price: {{ $product->price }}$</label></td><br>
                <td align="center"><label>Owner: </label> <a href="{{ route('profile', $product->user_id) }}">{{ $product->Owner }}</a></td>
                <br> <br> <hr>
            </tr>
            @else
            <h3>NO OUTPUT</h3>
        @endif
    </fieldset>
    @endsection
</x-layout>  