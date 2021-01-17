@extends('layouts.main')

@section('container')

    <style>
        .settings-container {
            max-width: 80%;
            margin: 0 auto;
        }
        a.nav-link {
            color: white;
        }
    </style>

    @include('settings.header')
    <div class="settings-container">
        @include('settings.go-back')
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link badge-ps" href="#">PromoStandards</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">API</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">CSV</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Excel</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">SAGE</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Shopify</a>
            </li>
        </ul>
    </div>


@endsection