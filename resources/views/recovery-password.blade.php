@extends('layouts.main')

@section('container')

    <style>

        .form-signin {
            width: 100%;
            max-width: 330px;
            padding: 15px;
            margin: auto;
        }
        .form-signin .checkbox {
            font-weight: 400;
        }
        .form-signin .form-control {
            position: relative;
            box-sizing: border-box;
            height: auto;
            padding: 10px;
            font-size: 16px;
        }
        .form-signin .form-control:focus {
            z-index: 2;
        }
        .form-signin input[type="email"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }
        .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }
    </style>

    <main class="form-signin">
            <form action="/recovery-password" method="post">
                @csrf
                <br><br>
                <p class="h5 my-0 me-md-auto fw-normal thundvel" style="text-align: center; font-size: 48px;">Thundvel</p>
                <br>
                <label for="inputEmail" class="visually-hidden">Email address</label>
                <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" autofocus>
                <br>
                <button class="w-100 btn btn-lg btn-thundvel" type="submit">Recover password</button>
            </form>
    </main>

@endsection