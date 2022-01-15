<div>
    <script>
        function onSubmit(token) 
        {
          document.getElementById("demo-form").submit();
        }

        function onClick(e) 
        {
            e.preventDefault();
            grecaptcha.ready(function() {
            grecaptcha.execute('6LcJoQQeAAAAAPoH-SAX7Kl9x4NV0xC5GvW1sZrK', {action: 'submit'}).then(function(token) {
                dd('test');
            });
            });
        }
    </script>
    <div class="row">
        <div class="col-md-12">
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
        </div>
    </div>
    @if($registerForm)
        <fieldset align="center">
            <legend>Register</legend>
            <form>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Name :</label>
                            <input type="text" wire:model="name" class="form-control">
                            @error('name') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Email :</label>
                            <input type="text" wire:model="email" class="form-control">
                            @error('email') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Password :</label>
                            <input type="password" wire:model="password" class="form-control">
                            @error('password') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-md-12 text-center">
                        <script src="https://www.google.com/recaptcha/api.js?render=6LcJoQQeAAAAAPoH-SAX7Kl9x4NV0xC5GvW1sZrK"></script>
                        <button class="g-recaptcha" 
                        data-sitekey="6LcJoQQeAAAAAPoH-SAX7Kl9x4NV0xC5GvW1sZrK" 
                        data-callback='onSubmit' 
                        data-action='submit'>Register</button>
                    </div>
                    <div class="col-md-12 text-center">
                        Or Login via <br>
                        <a href="{{ route('auth.facebook') }}">Facebook</a> or <a href="{{ route('auth.google') }}">Google</a>
                    </div>
                    <br>
                    <div class="col-md-12">
                        <a class="text-primary" wire:click.prevent="register"><strong style="cursor: pointer">Login</strong></a>
                    </div>
                </div>
            </form>
        </fieldset>
    @else
        <fieldset align="center">
            <legend>login</legend>
            <form>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Email :</label>
                            <input type="text" wire:model="email" class="form-control">
                            @error('email') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Password :</label>
                            <input type="password" wire:model="password" class="form-control">
                            @error('password') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-md-12 text-center">
                        <label for="remember">Remember me</label>
                        <input type="checkbox" wire:model="remember" name="remember" value="1">
                        <button class="btn text-white btn-success" wire:click.prevent="login">Login</button>
                    </div>
                    <div class="col-md-12 text-center">
                        Or Login via <br>
                        <a href="{{ route('auth.facebook') }}">Facebook</a> or <a href="{{ route('auth.google') }}">Google</a>
                    </div>
                    <div class="col-md-12">
                        Don't have account? <a class="btn btn-primary text-white" wire:click.prevent="register"><strong style="cursor: pointer">Register Here</strong></a>
                    </div>
                </div>
            </form>
        </fieldset>
    @endif
</div>