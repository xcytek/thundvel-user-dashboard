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

        .register-plan {
            width: 100%;
            padding: 20px;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            margin-bottom: 10px;
            cursor: pointer;
        }
        .plan-active {
            border: 2px solid #cb373d;
            background-color: #f8d7da;
        }
    </style>
    @include('super.suppliers.header')
    <div class="suppliers-section">
        @include('super.suppliers.go-back')
    </div>
    <main class="form-signin">
        <form action="/admin/supplier" method="post">
            @csrf
            <p class="h5 my-0 me-md-auto fw-normal thundvel" style="text-align: center; font-size: 24px;">Edit supplier</p>
            <br>
            <input type="hidden" name="supplier_id" value="{{ $supplier->id }}">
            <label for="inputName" class="visually-hidden">Name</label>
            <input type="text" name="name" value="{{ $supplier->name }}" id="inputName" class="form-control" placeholder="Name" autofocus>
            <br>
            <label for="inputCountry" class="visually-hidden">Country</label>
            <select name="country" id="inputCountry" class="form-control">
                <option value="N">-- Select one --</option>
                @foreach(['USA'] as $country)
                    <option @if($supplier->country === $country) {{ 'selected' }} @endif value="{{ $country }}"> {{ $country }} </option>
                @endforeach
            </select>
            <br>
            <label for="inputIndustry" class="visually-hidden">Industry</label>
            <input type="text" name="industry" value="{{ $supplier->industry }}" id="inputIndustry" class="form-control" placeholder="Industry" >
            <br>
            <label for="inputWebsite" class="visually-hidden">Website</label>
            <input type="text" name="website" value="{{ $supplier->website }}" id="inputWebsite" class="form-control" placeholder="Website" >
            <br>
            <label for="inputSubdomain" class="visually-hidden">Subdomain (unique)</label>
            <input type="text" name="subdomain" value="{{ $supplier->subdomain }}" id="inputSubdomain" class="form-control" placeholder="Subdomain (unique)" >
            <br>
            <label for="inputContactName" class="visually-hidden">Contract Name</label>
            <input type="text" name="contact_name" value="{{ $supplier->contact_name }}" id="inputContactName" class="form-control" placeholder="Contact name" >
            <br>
            <label for="inputPhone" class="visually-hidden">Phone</label>
            <input type="text" name="phone" value="{{ $supplier->phone }}" id="inputPhone" class="form-control" placeholder="Phone" >
            <br>
            <label for="inputEmail" class="visually-hidden">Email address</label>
            <input type="email" name="email" value="{{ $supplier->email }}" id="inputEmail" class="form-control" placeholder="Email address">
            <br>
            Select a plan <span style="font-size: 12px;"><a href="/#plans" target="_blank">(view plans)</a></span>
            <br><br>
            <input type="hidden" name="plan_id" value="1">
            @foreach($plans as $plan)
                <div class="register-plan @if(@$supplier->myPlan->plan->id === $plan->id) {{ 'plan-active' }} @endif" data-plan-id="{{ $plan->id }}">
                    {{ $plan->name }} - ${{ number_format($plan->cost, 2) }} USD
                </div>
            @endforeach
            <br><br>
            <button class="w-100 btn btn-lg btn-thundvel" type="submit">Update supplier</button>
        </form>
    </main>

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.register-plan').first().addClass('plan-active');

            $('.register-plan').click(function (e) {
                $('.register-plan').removeClass('plan-active');
                $(this).addClass('plan-active');
                $('input[name=plan_id]').val($(this).attr('data-plan-id'));
            });
        });
    </script>
@endsection