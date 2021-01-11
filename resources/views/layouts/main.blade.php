
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.79.0">
    <title>Thundvel</title>


    <!-- Bootstrap core CSS -->
    <link href="https://getbootstrap.com/docs/5.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="/docs/5.0/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
    <link rel="icon" href="/docs/5.0/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="/docs/5.0/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
    <link rel="manifest" href="/docs/5.0/assets/img/favicons/manifest.json">
    <link rel="mask-icon" href="/docs/5.0/assets/img/favicons/safari-pinned-tab.svg" color="#7952b3">
    <link rel="icon" href="/docs/5.0/assets/img/favicons/favicon.ico">
    <meta name="theme-color" content="#7952b3">


    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
        .thundvel {
            font-weight: 600;
            color: #cb373d;
        }
    </style>


    <!-- Custom styles for this template -->
    <link href="https://getbootstrap.com/docs/5.0/examples/pricing/pricing.css" rel="stylesheet">
</head>
<body>

<header class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
    <p class="h5 my-0 me-md-auto fw-normal thundvel">Thundvel</p>
    <nav class="my-2 my-md-0 me-md-3">
        @auth
            <a href="{{ url('/dashboard') }}" class="p-2 text-dark">Dashboard</a>
            <a href="{{ route('profile') }}" class="p-2 text-dark">My Profile</a>
            <a href="{{ route('logout') }}" class="p-2 text-dark">Logout</a>
        @else
            <a href="{{ route('login') }}" class="p-2 text-dark">Login</a>

            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="btn btn-outline-primary">Register</a>
            @endif
        @endauth

    </nav>
</header>
@if(session()->has('error') === true)
    <div class="alert alert-danger" role="alert">
        {{ session()->get('error') }}
    </div>
@endif
@if(session()->has('success') === true)
    <div class="alert alert-success" role="alert">
        {{ session()->get('success') }}
    </div>
@endif
@if (isset($sentRecovery) === true)
    <div class="alert alert-success" role="alert">
        You will receive an email with instructions to reset your password!
    </div>
@endif

@yield('container')

</body>
</html>
