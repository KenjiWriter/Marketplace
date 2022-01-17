<x-layout>
    @section('content')
    <div class="container text-center border border-dark">
        <div class="col-lg-4 col-lg-offset-4 form-row">
            <h3>Set up new password</h3>
            <h4>{{ $user->email }}</h4>
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
            <form method="POST" action="{{ url('auth/reset/'. $user->email.'/'.$code) }}" novalidate="">
                @csrf
                <div class="form-group">
                    <label for="password">Enter new password</label>
                    <input type="password" class="form-control" id="password" aria-describedby="passwordhelp" name="password" required placeholder="*****">
                    @error('password') <span class="text-danger error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirm password</label>
                    <input type="password" class="form-control" id="password_confirmation" aria-describedby="passwordhelp" name="password_confirmation" required placeholder="*****">
                    @error('password_confirm') <span class="text-danger error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <input type="submit" class="form-control btn btn-success" value="Change password">
                </div>
            </form>
        </div>
    </div>
    @endsection
</x-layout>