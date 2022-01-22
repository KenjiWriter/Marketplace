<div>
    @if($registerForm)
    <div class="container text-center border border-dark">
        <div class="col-lg-4 col-lg-offset-4 form-row">
            <h3>Register</h3>
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
            <form>
                <div class="form-group">
                    <label for="Email">Your name</label>
                    <input type="email" class="form-control" id="name" aria-describedby="emailHelp" wire:model="name" placeholder="Enter Your name">
                    @error('name') <span class="text-danger error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="Email">Email address</label>
                    <input type="email" class="form-control" id="Email" aria-describedby="emailHelp" wire:model="email" placeholder="Enter email">
                    @error('email') <span class="text-danger error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="Password">Password</label>
                    <input type="password" class="form-control" id="Password" wire:model="password" placeholder="Password">
                    @error('password') <span class="text-danger error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="Password_c">Confirm password</label>
                    <input type="password" class="form-control" id="Password_c" wire:model="password_confirmation" name="password_confirmation" placeholder="Password">
                    @error('password_confirmation') <span class="text-danger error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group form-inline">
                    <label for="question">Secure question</label> <br>
                    <label for="question">{{ $num1 }} + {{ $num2 }} = ?</label>
                    <input type="number" class="form-control" id="question" wire:model="user_result" required placeholder="Enter answer">
                </div>
                <div class="form-group">
                    <button class="btn text-white btn-success" wire:click.prevent="registerStore">Register</button>
                </div>
                <div class="form-group">
                    <label >Already have an account?</label> <br>
                    <button type="submit" class="btn btn-info" wire:click.prevent="register">Login</button>
                </div>
                <div class="form-group">
                    &mdash; Or login via &mdash;
                </div>
                <div class="form-group">
                    <a class="btn btn-primary" href="{{ route('auth.facebook') }}"> Facebook</a>
                </div>
                <div class="form-group">
                    <button  class="btn btn-danger">Google</button>
                </div>
            </form>
        </div>
    </div>
    @else
        <div class="container text-center border border-dark">
            <div class="col-lg-4 col-lg-offset-4 form-row">
                <h3>Login</h3>
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
                <form autocomplete="off">
                    <div class="form-group">
                        <label for="Email">Email address</label>
                        <input type="email" class="form-control" id="Email" aria-describedby="emailHelp" wire:model="email" placeholder="Enter email">
                        @error('email') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="Password">Password</label>
                        <input type="password" class="form-control" id="Password" wire:model="password" placeholder="Password">
                        @error('password') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                    <div class="text-right">
                        <a href="{{ route('auth.reset') }}">Forgot password?</a>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" wire:model="remember" id="remember" name="remember" value="1">
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>
                    <div class="form-group">
                        <button class="btn text-white btn-success" wire:click.prevent="login">Login</button>
                    </div>
                    <div class="form-group">
                        <label >Dont have an account yet?</label> <br>
                        <button type="submit" class="btn btn-info" wire:click.prevent="register">Register</button>
                    </div>
                    <div class="form-group">
                        &mdash; Or login via &mdash;
                    </div>
                </form>
                <div class="form-group">
                    <a class="btn btn-primary" href="{{ route('auth.facebook') }}"> Facebook</a>
                </div>
                <div class="form-group">
                    <a class="btn btn-danger" href="{{ route('auth.google') }}">Google</a>
                </div>
            </div>
        </div>
    @endif
</div>