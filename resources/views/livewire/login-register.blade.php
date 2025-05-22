<div class="container-xxl fade-in py-3">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 border-bottom">
                    <ul class="nav nav-pills nav-fill" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ !$registerForm ? 'active' : '' }} fw-medium py-2 px-4"
                                wire:click.prevent="register" aria-selected="{{ !$registerForm ? 'true' : 'false' }}">
                                <i class="ti ti-login me-2"></i>Login
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $registerForm ? 'active' : '' }} fw-medium py-2 px-4"
                                wire:click.prevent="register" aria-selected="{{ $registerForm ? 'true' : 'false' }}">
                                <i class="ti ti-user-plus me-2"></i>Register
                            </button>
                        </li>
                    </ul>
                </div>

                <div class="card-body p-4">
                    @if (session()->has('message'))
                        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                            <i class="ti ti-check me-2"></i>{{ session('message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session()->has('error'))
                        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                            <i class="ti ti-alert-circle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($registerForm)
                        <!-- Register Form -->
                        <h4 class="text-center mb-4 fw-semibold">Create an Account</h4>
                        <form>
                            <div class="mb-3">
                                <label for="name" class="form-label">Your Name</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="ti ti-user text-muted"></i></span>
                                    <input type="text" class="form-control" id="name" wire:model="name"
                                        placeholder="Enter your name">
                                </div>
                                @error('name')
                                    <div class="text-danger mt-1 small"><i
                                            class="ti ti-alert-circle me-1"></i>{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="ti ti-mail text-muted"></i></span>
                                    <input type="email" class="form-control" id="email" wire:model="email"
                                        placeholder="Enter your email">
                                </div>
                                @error('email')
                                    <div class="text-danger mt-1 small"><i
                                            class="ti ti-alert-circle me-1"></i>{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="ti ti-lock text-muted"></i></span>
                                    <input type="password" class="form-control" id="password" wire:model="password"
                                        placeholder="Create a password">
                                </div>
                                @error('password')
                                    <div class="text-danger mt-1 small"><i
                                            class="ti ti-alert-circle me-1"></i>{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i
                                            class="ti ti-lock-check text-muted"></i></span>
                                    <input type="password" class="form-control" id="password_confirmation"
                                        wire:model="password_confirmation" placeholder="Confirm your password">
                                </div>
                                @error('password_confirmation')
                                    <div class="text-danger mt-1 small"><i
                                            class="ti ti-alert-circle me-1"></i>{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="security_question" class="form-label d-flex align-items-center">
                                    <i class="ti ti-shield-lock me-2 text-primary"></i>Security Question
                                </label>
                                <div class="card bg-light border-0">
                                    <div class="card-body p-3">
                                        <p class="mb-2">Please solve this math problem:</p>
                                        <div class="d-flex align-items-center">
                                            <span class="fw-semibold me-2">{{ $num1 }} + {{ $num2 }} =
                                                ?</span>
                                            <div class="input-group" style="max-width: 120px;">
                                                <input type="number" class="form-control" id="security_question"
                                                    wire:model="user_result" placeholder="Answer">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <button
                                    class="btn btn-primary w-100 py-2 d-flex align-items-center justify-content-center"
                                    wire:click.prevent="registerStore">
                                    <i class="ti ti-user-plus me-2"></i>Create Account
                                </button>
                            </div>
                        </form>

                        <div class="text-center">
                            <p class="mb-3">Already have an account? <a href="#"
                                    wire:click.prevent="register" class="text-decoration-none">Sign in</a></p>

                            <div class="position-relative my-4">
                                <hr>
                                <span
                                    class="position-absolute top-50 start-50 translate-middle px-3 bg-white text-muted small">Or
                                    sign up with</span>
                            </div>

                            <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                                <a href="{{ route('auth.facebook') }}"
                                    class="btn btn-outline-primary flex-grow-1 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-brand-facebook me-2"></i>Facebook
                                </a>
                                <a href="{{ route('auth.google') }}"
                                    class="btn btn-outline-danger flex-grow-1 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-brand-google me-2"></i>Google
                                </a>
                            </div>
                        </div>
                    @else
                        <!-- Login Form -->
                        <h4 class="text-center mb-4 fw-semibold">Welcome Back</h4>
                        <form>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i
                                            class="ti ti-mail text-muted"></i></span>
                                    <input type="email" class="form-control" id="email" wire:model="email"
                                        placeholder="Enter your email">
                                </div>
                                @error('email')
                                    <div class="text-danger mt-1 small"><i
                                            class="ti ti-alert-circle me-1"></i>{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <div class="d-flex justify-content-between">
                                    <label for="password" class="form-label">Password</label>
                                    <a href="{{ route('auth.reset') }}" class="text-decoration-none small">Forgot
                                        password?</a>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i
                                            class="ti ti-lock text-muted"></i></span>
                                    <input type="password" class="form-control" id="password" wire:model="password"
                                        placeholder="Enter your password">
                                </div>
                                @error('password')
                                    <div class="text-danger mt-1 small"><i
                                            class="ti ti-alert-circle me-1"></i>{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4 form-check">
                                <input type="checkbox" class="form-check-input" id="remember"
                                    wire:model="remember">
                                <label class="form-check-label" for="remember">Remember me</label>
                            </div>

                            <div class="mb-3">
                                <button
                                    class="btn btn-primary w-100 py-2 d-flex align-items-center justify-content-center"
                                    wire:click.prevent="login">
                                    <i class="ti ti-login me-2"></i>Sign In
                                </button>
                            </div>
                        </form>

                        <div class="text-center">
                            <p class="mb-3">Don't have an account? <a href="#" wire:click.prevent="register"
                                    class="text-decoration-none">Create one</a></p>

                            <div class="position-relative my-4">
                                <hr>
                                <span
                                    class="position-absolute top-50 start-50 translate-middle px-3 bg-white text-muted small">Or
                                    sign in with</span>
                            </div>

                            <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                                <a href="{{ route('auth.facebook') }}"
                                    class="btn btn-outline-primary flex-grow-1 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-brand-facebook me-2"></i>Facebook
                                </a>
                                <a href="{{ route('auth.google') }}"
                                    class="btn btn-outline-danger flex-grow-1 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-brand-google me-2"></i>Google
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="text-center mt-4">
                <p class="text-muted small">
                    By continuing, you agree to our
                    <a href="#" class="text-decoration-none">Terms of Service</a> and
                    <a href="#" class="text-decoration-none">Privacy Policy</a>
                </p>
            </div>
        </div>
    </div>
</div>
