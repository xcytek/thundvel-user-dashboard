@extends('layouts.main')

@section('container')

    <style>
        .workspace-section {
            max-width: 80%;
            margin: 0 auto;
        }
    </style>

    <div class="workspace-section">

        @include('workspaces.go-back')

        <div class="row">
            <div class="col-4">
                <h6>Workspace</h6>
                <h2>{{ $workspace->name }}</h2>
                <h4><span class="badge rounded-pill badge-{{ $workspace->dataSource->short_name }}">{{ $workspace->dataSource->name }}</span></h4>
            </div>
            <div class="col-8" style="border-left: 1px solid #4a5568;">
                <p>{{ $workspace->description }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-9">
                Data visualization
            </div>
            <div class="col-3" style="border-left: 1px solid #4a5568;">
                Connectivity log
            </div>
        </div>
    </div>



@endsection