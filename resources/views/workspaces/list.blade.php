@extends('layouts.main')

@section('container')
    <style>
        .list {
            max-width: 80%;
            margin: 0 auto;
        }

        .workspace-card {
            width: 100%;
            border-radius: 5px;
            border: 1px solid #4a5568;
            padding: 25px;
            margin: 2%;
        }

        .workspace-name {
            font-size: 16px;
            font-weight: 600;
        }

        .workspace-description {
            font-size: 13px;
        }

    </style>

    @include('workspaces.header')

    <div class="list">
        <div class="row">
            @foreach($workspaces as $workspace)
                <div class="col-3">
                    <div class="workspace-card">
                        <div class="workspace-name">{{ $workspace->name }}</div>
                        <div class="workspace-source"><span class="badge rounded-pill badge-{{ $workspace->dataSource->short_name }}">{{ $workspace->dataSource->name }}</span></div>
                        <div class="workspace-description">{{ $workspace->description }}</div>
                        <br>
                        <a class="w-100 btn btn-outline-thundvel" href="{{ url('/workspaces/' . $workspace->id) }}">Enter</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection