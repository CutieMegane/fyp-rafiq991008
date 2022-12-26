<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width initial-scale=1">
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <link href="/scripts/bootstrap-5.2.0-beta1-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link href="/fontawesome-free-6.1.1-web/css/all.css" rel="stylesheet">
    <script src="/scripts/bootstrap-5.2.0-beta1-dist/js/bootstrap.min.js"></script>
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
                    <a class="nav-link" href="{{ route('user.index') }}" id="nav2"> Manage User</a>
                </li>
                @endif

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('certs.index') }}" id="nav3">+Cert</a>
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


    <footer class="footer mt-auto py-3 bg-light" style="position:fixed; bottom: 0; width:100%;">
        <div class="container">
            <span class="text-muted" style="opacity:15%"> Built with Laravel 9.42.2 with love. And Bootstrap 5 too. 2022 CutieMegane :)</span>
        </div>
    </footer>
</body>