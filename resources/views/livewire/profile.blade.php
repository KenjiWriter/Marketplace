<fieldset>
    <legend>System by <a href="https://github.com/KenjiWriter">@Wenzzi</a></legend>
    @if ($user)
        <h3 align="center">Profile {{ $user->name }}</h3>
        Joined in: {{ $user->created_at->toFormattedDateString() }} <br>
        @if($products && $count_all > 0)
            Announcements: {{ $count_all }} <br>
            Active announcements ({{ $products->count() }}): <br> 
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
                <td>| Added:  {{ $product->created_at->diffForHumans() }}</td>
                <td>| </td>
            </tr><hr>
        @endforeach
        @endif
    @else
        <h3>NO OUTPUT</h3>
    @endif
</fieldset>
