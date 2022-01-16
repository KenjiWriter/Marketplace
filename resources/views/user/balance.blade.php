<x-layout>
    @section('content')
        <div class="container text-center border border-dark">
            <div class="col-lg-4 col-lg-offset-4 form-row">
                <h3>Add Balance</h3>
                @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
                @endif
                @if (session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('balance.add') }}">
                    @csrf
                    <div class="form-group">
                        <label for="Deposit">Deposit amount</label>
                        <input type="number" class="form-control" id="Deposit" aria-describedby="Deposit" name="amount" placeholder="Deposit amount">
                        <small class="text-info">(Minimum deposit amount is 5$)</small>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="form-control btn btn-success" value="Confirm transfer">
                    </div>
                </form>
            </div>
        </div>
    @endsection
</x-layout>