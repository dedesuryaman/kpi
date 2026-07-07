<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>KPI MANAGEMENT</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/logo.png') }}">
    <!-- Fonts -->

    <link rel="stylesheet" href="{{ asset('assets/css/welcome-screen.css') }}">
    <!-- Styles -->
</head>

<body>

    <div class="flex-center position-ref full-height">
        <div class="top-right links">

            @if (Route::has('login'))

            @auth
            <a href="{{ url('/dashboard') }}" class="">
                Dashboard
            </a>


            <a href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i>
                <span key="t-logout">Logout</span>
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>

            @else
            <a href="{{ route('login') }}" class="">
                <i class="fa fa-user mr-2"></i> Log in
            </a>

            @if (Route::has('register'))
            <a href="{{ route('register') }}" class="">
                Register
            </a>
            @endif
            @endauth

            @endif

        </div>

        <div class="content">
            <div class="title m-b-md">
                <img id="main-logo" class="d-inline-block align-top mr-1" style="max-width: 250px;"
                    src="{{ asset('assets/images/logo.png') }}" alt="E-Polres">
            </div>
            <div class="title m-b-md">
                KPI MANAGEMENT
            </div>
            <br>
            <p class="text-white">©Copyright {{ date('Y') }}</p>
        </div>
    </div>

</body>

</html>