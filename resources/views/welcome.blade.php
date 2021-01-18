@extends('layouts.welcome')

@section('container')
    <div class="row text-center">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <p class="thundvel-text">Thundvel</p>
            <p class="thundvel-small-text">
                Predict and get recommendations
                <br> about your products <br>
                <br> <a href="{{ url('/signup') }}">Sign up Now!</a>
            </p>
        </div>
    </div>
@endsection