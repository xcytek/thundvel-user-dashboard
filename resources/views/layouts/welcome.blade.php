
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Predict and get recommendations about your products">
    <meta name="author" content="Thundvel - Data services for Promotional Products Industry">
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

        .supplier-name {
            font-weight: 300;
            font-size: 14px;
        }

        .btn-thundvel {
            background-color: #cb373d;
            color: white;
        }

        .btn-thundvel:hover {
            color: #d4babc;
        }

        .btn-outline-thundvel {
            background-color: transparent;
            color: #cb373d;
            border-color: #cb373d;
        }

        .btn-outline-thundvel:hover {
            background-color: #cb373d;
            color: white;
        }

        a {
            color: #cb373d;
        }

        a:hover {
            color: #cb373d;
        }
        .badge-ps {
            margin: 0 0 15px 0;
            background-color: #006db0;
        }

        .badge-api {
            margin: 0 0 15px 0;
            background-color: #7145BD;
        }

        .badge-csv {
            margin: 0 0 15px 0;
            background-color: #FFC300;
        }

        .badge-excel {
            margin: 0 0 15px 0;
            background-color: #13B254;
        }

        .badge-sage {
            margin: 0 0 15px 0;
            background-color: #a1192e;
        }

        .badge-shopify {
            margin: 0 0 15px 0;
            background-color: #165BD3
        }

        .thundvel-text {
            font-weight: 600;
            font-size: 100px;
            color: #cb373d;
        }

        .thundvel-small-text {
            margin-top: -40px;
            font-size: 20px;
            color:black;
        }

    </style>


    <!-- Custom styles for this template -->
    <link href="https://getbootstrap.com/docs/5.0/examples/pricing/pricing.css" rel="stylesheet">
</head>
<body>

<header class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
    <p class="h5 my-0 me-md-auto fw-normal"><span class="thundvel">Thundvel</span> @if (isset($subdomain))<span class="supplier-name">{{ $subdomain }} @endif</span></p>
    <nav class="my-2 my-md-0 me-md-3">
        <a href="{{ url('/signup') }}" class="p-2 text-dark">Sign up</a>
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

@yield('container')

@include('layouts.scripts')

@yield('scripts')

</body>
</html>
