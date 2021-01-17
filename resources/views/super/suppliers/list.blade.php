@extends('layouts.main')

@section('container')
    <style>
        .list {
            max-width: 80%;
            margin: 0 auto;
        }

    </style>

    @include('super.suppliers.header')

    <div class="list">
        <table class="table table-striped">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Country</th>
                <th>Industry</th>
                <th>Subdomain</th>
                <th>Contact Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Status</th>
                <th>Created At</th>
                <th></th>
                <th></th>
            </tr>
            @foreach($suppliers as $supplier)
                <tr>
                    <td>{{ $supplier->id }}</td>
                    <td>{{ $supplier->name }}</td>
                    <td>{{ $supplier->country }}</td>
                    <td>{{ $supplier->industry }}</td>
                    <td>{{ $supplier->subdomain }}</td>
                    <td>{{ $supplier->contact_name }}</td>
                    <td>{{ $supplier->phone }}</td>
                    <td>{{ $supplier->email }}</td>
                    <td>@if($supplier->is_enabled) Enabled @else Disabled @endif</td>
                    <td>{{ $supplier->created_at }}</td>
                    <td>
                        @if($supplier->is_enabled)
                            <a href="/admin/supplier/{{ $supplier->id }}/disable">Disable</a>
                        @else
                            <a href="/admin/supplier/{{ $supplier->id }}/enable">Enable</a>
                        @endif
                    </td>
                    <td><a href="" class="btn btn-outline-danger">Delete</a></td>
                </tr>
            @endforeach
        </table>

    </div>

@endsection