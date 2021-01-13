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
    @include('workspaces.header')
    <main class="form-signin">
        <form action="/workspace" method="post">
            @csrf
            <p class="h5 my-0 me-md-auto fw-normal thundvel" style="text-align: center; font-size: 24px;">New workspace</p>
            <br>
            <label for="inputName" class="visually-hidden">Workspace name</label>
            <input type="text" name="name" id="inputName" class="form-control" placeholder="Workspace name" autofocus>
            <br>
            <label for="selectDataSource" class="visually-hidden">Data Source</label>
            <select name="data_source_id" id="selectDataSource" class="form-control">
                <option value="0">-- Select one --</option>
                @foreach($data_sources as $dataSource)
                    <option value="{{ $dataSource->id }}"> {{ $dataSource->name }} </option>
                @endforeach
            </select>
            <br>
            <label for="textDescription" class="visually-hidden">Description</label>
            <textarea name="description" id="textDescription" class="form-control"></textarea>
            <br>
            <button class="w-100 btn btn-lg btn-thundvel" type="submit">Create workspace</button>
        </form>
    </main>


@endsection