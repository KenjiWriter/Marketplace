<x-layout>
    @section('content')
    <fieldset>
        <legend>System by <a href="https://github.com/KenjiWriter">@Wenzzi</a></legend>
        <h1 align="center">Messages</h1>
        @isset($collectionBuying)
            <h2>Buying:</h2>
            @foreach ($collectionBuying as $buying)
                <?php 
                    $product = App\Models\product::where('id',$buying["product"])->select('name', 'Owner')->first();
                ?>
                <a href="{{ route('chat', $buying['roomId']) }}">{{ $product->name }} <small>from {{ $product->Owner }}</small></a> [Last message: {{ $buying['time'] }}]
            @endforeach
        @endisset
        @isset($collectionSelling)
            <hr>
            <h2>Selling:</h2>
            @foreach ($collectionSelling as $selling)
                <?php 
                    $product = App\Models\product::where('id',$selling["product"])->select('name', 'Owner')->first();
                ?>
                <a href="{{ route('chat', $selling['roomId']) }}">{{ $product->name }}</a> [Last message: {{ $selling['time'] }}]
            @endforeach
        @endisset
    </fieldset>
    @endsection
</x-layout>