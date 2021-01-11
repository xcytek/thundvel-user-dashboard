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
        <form action="/register" method="post">
            @csrf
            <br><br>
            <p class="h5 my-0 me-md-auto fw-normal thundvel" style="text-align: center; font-size: 48px;">Thundvel</p>
            <br>
            <label for="inputFirstName" class="visually-hidden">First Name</label>
            <input type="text" name="first_name" id="inputFirstName" class="form-control" placeholder="First name" autofocus>
            <br>
            <label for="inputLastName" class="visually-hidden">Last Name</label>
            <input type="text" name="last_name" id="inputLastEmail" class="form-control" placeholder="Last name">
            <br>
            <label for="inputEmail" class="visually-hidden">Email address</label>
            <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address">
            <br>
            <label for="inputPassword" class="visually-hidden">Password</label>
            <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password">
            <br>
            <a href="{{ route('login') }}">Already have an account?</a>
            <br><br>
            <button class="w-100 btn btn-lg btn-primary" type="submit">Sign up</button>
        </form>
    </main>

@endsection