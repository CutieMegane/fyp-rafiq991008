<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width initial-scale=1">
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link href="/fontawesome-free-6.1.1-web/css/all.css" rel="stylesheet">

    <!--colorChanger-->
    <script src="scripts/colorChanger.js"></script>
    <!-- preinstalled bootstrap 
    <link href="/scripts/bootstrap-5.2.0-beta1-dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="/scripts/bootstrap-5.2.0-beta1-dist/js/bootstrap.min.js"></script>
        ends here-->

    <!-- Recommended proper auto-update bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</head>

<body>
    <!-- navigation baaaa bg-dark navbar-dark-->
    <nav class="navbar navbar-expand-sm ">
        <div class="container-fluid">
            <ul class="navbar-nav">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <img src="/img/icon.png" alt="Home" style="width:30px;">
                </a>

                @guest
                <span class="navbar-text" href="{{route('home')}}">eCert Signing System</span>
                @endguest

                @auth
                <span class="navbar-text">Welcome {{ Auth::user()->name }}</span>
                @endauth

                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('home') }}" id="nav1">Verify Cert</a>
                </li>
                @auth
                @if (Auth::user()->operator)
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.index') }}" id="nav2">Manage User</a>
                </li>
                @endif

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('certs.index') }}" id="nav3">Manage Cert</a>
                </li>
                @endauth
            </ul>

            <ul class="navbar-nav">
                @guest
                <a class="nav-link" href="{{ route('login') }}">
                    Login
                </a>
                @endguest

                @auth
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none"> @csrf </form>
                </li>
                @endauth
            </ul>
        </div>
    </nav>

    <!-- laravel where content is insert automatik -->
    <div class="container" style="margin-top:30px">
        @yield('content')
        @show
    </div>


    <footer class="footer mt-auto py-3" style="position:fixed; bottom: 0; width:100%;">
        <div class="container">
            <button type="button" class="btn btn-outline-light" onclick='setTheme("light")'>Light</button>
            <button type="button" class="btn btn-outline-dark" onclick='setTheme("dark")'>Dark</button>
            <span class="text-muted" style="opacity:15%"> Built with Laravel 9.42.2 with love. And Bootstrap 5 too. 2022-2023 CutieMegane :)</span>
        </div>
    </footer>
</body>