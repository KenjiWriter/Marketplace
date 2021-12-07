<x-layout>
    @section('content')
    <fieldset>
        <legend>System by <a href="https://github.com/KenjiWriter">@Wenzzi</a></legend>
        <form method="POST" action="{{ route('post.edit2') }}">
        @csrf
        <label>Title</label>
        <input type="text" value="{{ $product->name }}" name="title" placeholder="title"><br>
        <label for="owner">I'm a first owner: </label> <input id="Owner" type="checkbox" name="first_owner" @if($product->First_owner == 1) checked @endif><br>
        Category: 
        <select name="category"> <br>
            <option value="0">Select category</option>
            <option value="1" @if($product->category == 1) selected @endif>Phones </option>
            <option value="2" @if($product->category == 2) selected @endif>Tablets</option>
            <option value="3" @if($product->category == 3) selected @endif>Computers</option>
            <option value="4" @if($product->category == 4) selected @endif>Other</option>
        </select> <br> <br>
        <label>Price</label>
        <input type="hidden" name="id" value="{{ $product->id }}">
        <input type="number" name="price" value="{{ $product->price }}" placeholder="Price"> <br> <br>
        <input type="submit" value="Edit">
        </form>
    </fieldset>
    @endsection
</x-layout>