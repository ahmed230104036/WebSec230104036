@extends('layouts.app')

@section('title', 'Users & Roles Management')

@section('content')
<div class="container">
    <h2>Users & Roles Management</h2>

    @if(auth()->user()->role == 'Admin')
        <a href="{{ route('roles.index') }}" class="btn btn-success mb-3">Manage Roles</a>
    @endif

    @if(auth()->user()->role == 'Admin')
    <a href="{{ route('users.create') }}" class="btn btn-success mb-3">Add New User</a>
    @endif

    <h3 class="mt-4">Users</h3>
    @if(auth()->user()->role == 'Admin' || auth()->user()->role == 'Employee')
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td><span class="badge bg-info">{{ $user->role }}</span></td>
                        <td>
                            @if(auth()->user()->role == 'Admin' || (auth()->user()->role == 'Employee' && $user->role != 'Admin'))
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            @endif
                            @if(auth()->user()->role == 'Admin' && $user->role != 'Admin')
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="alert alert-warning">You do not have permission to view this page.</p>
    @endif

    @if(auth()->user()->role == 'Admin')
        <h3 class="mt-4">Roles</h3>
        <a href="{{ route('roles.create') }}" class="btn btn-success">Add New Role</a>
        <table class="table table-striped table-hover mt-2">
            <thead class="table-dark">
                <tr>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $role)
                    <tr>
                        <td>{{ $role->name }}</td>
                        <td>
                            <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            <a href="{{ route('roles.permissions', $role->id) }}" class="btn btn-sm btn-warning">Manage Permissions</a>
                            <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection


































































