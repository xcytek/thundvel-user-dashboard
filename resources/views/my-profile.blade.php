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
        <form action="/my-profile" method="post">
            @csrf
            <br><br>
            <p class="h5 my-0 me-md-auto fw-normal" style="text-align: center;">My Profile</p>
            <br>
            <label for="inputFirstName" class="visually-hidden">First Name</label>
            <input type="text" value="{{ $user->first_name }}" name="first_name" id="inputFirstName" class="form-control" placeholder="First name" autofocus>
            <br>
            <label for="inputLastName" class="visually-hidden">Last Name</label>
            <input type="text" value="{{ $user->last_name }}" name="last_name" id="inputLastEmail" class="form-control" placeholder="Last name">
            <br>
            <label for="inputEmail" class="visually-hidden">Email address</label>
            <input type="email" value="{{ $user->email }}" name="email" id="inputEmail" class="form-control" placeholder="Email address">
            <br>
            <button class="w-100 btn btn-lg btn-thundvel" type="submit">Update my profile</button>
        </form>
    </main>

@endsection