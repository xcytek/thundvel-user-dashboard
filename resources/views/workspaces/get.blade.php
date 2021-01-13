@extends('layouts.main')

@section('container')

    <style>
        .workspace-section {
            max-width: 80%;
            margin: 0 auto;
        }
    </style>

    @include('workspaces.header')

    <div class="workspace-section">

        @include('workspaces.go-back')

        <div class="row">
            <div class="col-4">
                <h3>{{ $workspace->name }}</h3>
                <h4><span class="badge rounded-pill badge-{{ $workspace->dataSource->short_name }}">{{ $workspace->dataSource->name }}</span></h4>
            </div>
            <div class="col-8" style="border-left: 1px solid #4a5568;">
                <h6>{{ $workspace->description }}</h6>
            </div>
        </div>
        <div class="row">
            <div class="col-6">Any chart</div>
            <div class="col-6">Connectivity status and history</div>
        </div>
    </div>



@endsection