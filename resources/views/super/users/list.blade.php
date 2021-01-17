@extends('layouts.main')

@section('container')
    <style>
        .list {
            max-width: 80%;
            margin: 0 auto;
        }

    </style>

    @include('super.users.header')

    <div class="list">
        <table class="table table-striped">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Created At</th>
                <th></th>
                <th></th>
            </tr>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->first_name }}</td>
                    <td>{{ $user->last_name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role->name }}</td>
                    <td>@if($user->is_enabled) Enabled @else Disabled @endif</td>
                    <td>{{ $user->created_at }}</td>
                    <td>
                        @if($user->role->name !== 'SuperAdmin')
                            @if($user->is_enabled)
                                <a href="/admin/user/{{ $user->id }}/disable">Disable</a>
                            @else
                                <a href="/admin/user/{{ $user->id }}/enable">Enable</a>
                            @endif
                        @endif
                    </td>
                    <td>
                        @if($user->role->name !== 'SuperAdmin')
                            <a href="" class="btn btn-outline-danger">Delete</a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>

    </div>

@endsection