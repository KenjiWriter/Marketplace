<x-layout>
    @section('content')
    <div class="container text-center border border-dark">
        <div class="col-lg-4 col-lg-offset-4 form-row">
            <h3>Forgot password</h3>
            @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
            @endif
            <form method="POST" action="{{ route('auth.reset.send') }}" novalidate="">
                @csrf
                <div class="form-group">
                    <label for="email">Enter your E-mail</label>
                    @if (session()->has('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <input type="emial" class="form-control" id="email" aria-describedby="emailhelp" name="email" required placeholder="mail@email.com"  value="{{ old('email') }}" >
                    @error('email') <span class="text-danger error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <input type="submit" class="form-control btn btn-success" value="Send Password link">
                </div>
            </form>
        </div>
    </div>
    @endsection
</x-layout>