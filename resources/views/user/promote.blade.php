<x-layout>
    @section('content')
        <fieldset align="center">
            <legend align="left">System by <a href="https://github.com/KenjiWriter">@Wenzzi</a></legend>
            <h1>Choose promotion plan</h1>
            @if (!empty($promoting_to))
                <small> Your announcement are promoting to [{{ $promoting_to }}]</small>
            @endif
            @if (session()->has('message'))
            <div>
                <span style="color: red;">{{ session('message') }}</span>
            </div>
            @endif
            @if (session()->has('balance'))
            <div>
                <span style="color: red;">Not enought balance. <a href="{{ route('balance') }}">Add your balance balance</a></span>
            </div>
            @endif
            @if (session()->has('success'))
            <div>
                <span style="color: green;">{{ session('success') }}</span>
            </div>
            @endif
            <br> <hr>
            <form method="POST" action="{{ route('promote.add') }}">
                @csrf
                <input type="hidden" name="days" value="3">
                <input type="hidden" name="id" value="{{ $id }}">
                <label style="font-size: 24px;">3 days for 5$</label> <br>
                <input style="height: 100px; width: 250px;" type="submit" value="3days promoting">
            </form> <br>
            <form method="POST" action="{{ route('promote.add') }}">
                @csrf
                <input type="hidden" name="days" value="14">
                <input type="hidden" name="id" value="{{ $id }}">
                <label style="font-size: 24px;">14 days for 15$</label> <br>
                <input style="height: 100px; width: 250px;" type="submit" value="14days promoting">
            </form> <br>
            <form method="POST" action="{{ route('promote.add') }}">
                @csrf
                <input type="hidden" name="days" value="30">
                <input type="hidden" name="id" value="{{ $id }}">
                <label style="font-size: 24px;">30 days for 30$</label> <br>
                <input style="height: 100px; width: 250px;" type="submit" value="30days promoting">
            </form>
        </fieldset>
    @endsection
</x-layout>