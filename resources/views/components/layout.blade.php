<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CherryDev</title>
    @livewireStyles
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <!-- Bootstrap core CSS -->
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">

    <!-- Add custom CSS here -->
    <link href="{{ asset('css/shop-homepage.css') }}" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ route('index') }}">Wenzzi Marketplace</a>
            </div>
    
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav">
                    @if (!Auth::guest())
                        <li><a href="{{ route('post.add') }}">Create new announcement</a>
                        </li>
                        <li><a href="{{route('profile', auth()->user()->id) }}">Profile</a>
                        </li>
                        <li><a href="{{route('messages')}}">Messages</a>
                        </li>
                        <li> </li>
                        <li><a href="{{ route('balance') }}">Balance: {{ auth()->user()->balance }}$ [Add balance]</a></li>
                        <li class="nav-item">
                            <form class = "navbar-form navbar-right" action="{{ route('auth.logout') }}" method="POST"  role="logout">
                                @csrf
                                <button class="btn btn-danger text-white" type="submit">Logout</button>
                            </form>
                        </li>
                        @else
                        <li><a href="{{ route('auth') }}">Login/Register</a></li>
                    @endif
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
    @if (session()->has('global_error'))
        <div class="alert alert-danger">
            {{ session('global_error') }}
        </div>
    @endif
    @if (session()->has('global_message'))
        <div class="alert alert-success">
            {{ session('global_message') }}
        </div>
    @endif
    @yield('content')
    <div class="container">

        <hr>
    
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; 2022 <a href="https://github.com/KenjiWriter">Wenzzi</a>
                    </p>
                </div>
            </div>
        </footer>
    
    </div>
    <!-- /.container -->
    
    <!-- JavaScript -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.js"></script>
    @livewireScripts
</body>
</html>