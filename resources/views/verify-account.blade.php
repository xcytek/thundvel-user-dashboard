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
        input[type=text] {
            text-align: center;
        }
    </style>

    <main class="form-signin">
        <form action="/verify-account" method="post">
            @csrf
            <br><br>
            <p class="h5 my-0 me-md-auto fw-normal thundvel" style="text-align: center; font-size: 48px;">Thundvel</p>
            <br>
            <label for="inputCode" class="visually-hidden">Verify code</label>
            <input type="text" name="code" id="inputCode" class="form-control" placeholder="Verify code" autofocus>
            <br>
            <button class="w-100 btn btn-lg btn-primary" type="submit">Verify account</button>
        </form>
    </main>

@endsection