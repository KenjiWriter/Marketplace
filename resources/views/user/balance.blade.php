<x-layout>
    @section('content')
        <fieldset align="center">
            <legend align="left">System by <a href="https://github.com/KenjiWriter">@Wenzzi</a></legend>
            <h3>Add Balance</h3>
            @if (session()->has('message'))
            <div>
                <span style="color: red;">{{ session('message') }}</span>
            </div>
            @endif
            @if (session()->has('success'))
            <div>
                <span style="color: green;">{{ session('success') }}</span>
            </div>
            @endif
            <form method="POST" action="{{ route('balance.add') }}">
                @csrf
                <input type="number" style="width: 105px;" name="amount" placeholder="Deposit amount"> $ <br>
                <small>(Minimum deposit amount is 5$)</small> <br>
                <input type="submit" style="width: 115px;" value="Confirm transfer">
            </form>
        </fieldset>
    @endsection
</x-layout>