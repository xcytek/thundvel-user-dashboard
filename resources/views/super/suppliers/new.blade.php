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
        .suppliers-section {
            max-width: 80%;
            margin: 0 auto;
        }
    </style>
    @include('super.suppliers.header')
    <div class="suppliers-section">
        @include('super.suppliers.go-back')
    </div>
    <main class="form-signin">
        <form action="/admin/supplier" method="post">
            @csrf
            <p class="h5 my-0 me-md-auto fw-normal thundvel" style="text-align: center; font-size: 24px;">New supplier</p>
            <br>
            <label for="inputName" class="visually-hidden">Name</label>
            <input type="text" name="name" id="inputName" class="form-control" placeholder="Name" autofocus>
            <br>
            <label for="inputCountry" class="visually-hidden">Country</label>
            <select name="country" id="inputCountry" class="form-control">
                <option value="N">-- Select one --</option>
                @foreach(['USA'] as $country)
                    <option value="{{ $country }}"> {{ $country }} </option>
                @endforeach
            </select>
            <br>
            <label for="inputIndustry" class="visually-hidden">Industry</label>
            <input type="text" name="industry" id="inputIndustry" class="form-control" placeholder="Industry" >
            <br>
            <label for="inputWebsite" class="visually-hidden">Website</label>
            <input type="text" name="website" id="inputWebsite" class="form-control" placeholder="Website" >
            <br>
            <label for="inputSubdomain" class="visually-hidden">Subdomain (unique)</label>
            <input type="text" name="subdomain" id="inputSubdomain" class="form-control" placeholder="Subdomain (unique)" >
            <br>
            <label for="inputContactName" class="visually-hidden">Contract Name</label>
            <input type="text" name="contact_name" id="inputContactName" class="form-control" placeholder="Contact name" >
            <br>
            <label for="inputPhone" class="visually-hidden">Phone</label>
            <input type="text" name="phone" id="inputPhone" class="form-control" placeholder="Phone" >
            <br>
            <label for="inputEmail" class="visually-hidden">Email address</label>
            <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address">
            <br>
            <button class="w-100 btn btn-lg btn-thundvel" type="submit">Create supplier</button>
        </form>
    </main>


@endsection