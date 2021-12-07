<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CherryDev</title>
    @livewireStyles
</head>
<body>
    @yield('content')
    <nav>
        <a href="{{ route('index') }}">Main page</a> |
        @if (!Auth::guest())
        <a href="{{ route('post.add') }}">Create new announcement</a> |
        <a href="{{route('post.show',auth()->user()->id) }}">My announcement</a> |
        <a href="{{route('profile', auth()->user()->id) }}">Profile</a>
        <form method="POST" action="{{ route('auth.logout') }}">
            @csrf
            <input type="submit" value="Logout">
        </form>
            @else
            <a href="{{route('auth') }}">Login/Register</a>
        @endif
        </nav>
    @livewireScripts
</body>
</html>