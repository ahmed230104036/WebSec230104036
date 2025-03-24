@extends('layouts.master')

@section('title', 'Manage Users')

@section('content')
    <div class="container mt-4">
        <h2 class="text-center">Users List</h2>

        @if(auth()->user()->role === 'admin')
            <div class="text-end mb-3">
                <a href="{{ route('users.create') }}" class="btn btn-success">Add New User</a>
            </div>
        @endif

        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td><span class="badge bg-info">{{ ucfirst($user->role) }}</span></td>
                    <td>
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm">Edit</a>
                        @if(auth()->user()->role === 'admin')
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
