<fieldset>
<legend>System by <a href="https://github.com/KenjiWriter">@Wenzzi</a> | {{ $product->Owner }} announcement</legend>
@if ($products && $products->count() > 0)
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
                <td>| Added:  {{ $product->created_at->diffForHumans() }} by {{ $product->Owner }}</td>
            </tr><hr> <br>
        @endforeach
        @else
        <h3>NO OUTPUT</h3>
        <legend>Filtring system by <a href="https://github.com/KenjiWriter">@Wenzzi</a></legend>
@endif
</fieldset>