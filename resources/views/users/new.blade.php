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
        .users-section {
            max-width: 80%;
            margin: 0 auto;
        }
    </style>
    @include('users.header')
    <div class="users-section">
        @include('users.go-back')
    </div>
    <main class="form-signin">
        <form action="/user" method="post">
            @csrf
            <p class="h5 my-0 me-md-auto fw-normal thundvel" style="text-align: center; font-size: 24px;">New user</p>
            <br>
            <label for="inputName" class="visually-hidden">First Name</label>
            <input type="text" name="first_name" id="inputName" class="form-control" placeholder="First name" autofocus>
            <br>
            <label for="inputLastName" class="visually-hidden">Last Name</label>
            <input type="text" name="last_name" id="inputLastName" class="form-control" placeholder="Last name" autofocus>
            <br>
            <label for="inputEmail" class="visually-hidden">Email address</label>
            <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address">
            <br>
            <label for="selectRole" class="visually-hidden">Role</label>
            <select name="role_id" id="selectRole" class="form-control">
                <option value="0">-- Select one --</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}"> {{ $role->name }} </option>
                @endforeach
            </select>
            <br>
            <button class="w-100 btn btn-lg btn-thundvel" type="submit">Create workspace</button>
        </form>
    </main>


@endsection