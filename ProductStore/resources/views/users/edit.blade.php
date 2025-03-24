@extends('layouts.master')

@section('title', 'Edit User')

@section('content')
    <div class="container mt-5">
        <h2 class="text-center">Edit User</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" required>
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Role:</label>
                <select name="role" id="role" class="form-select" required>
                    <option value="customer" {{ $user->role == 'customer' ? 'selected' : '' }}>Customer</option>
                    <option value="employee" {{ $user->role == 'employee' ? 'selected' : '' }}>Employee</option>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary w-100">Update User</button>
        </form>
    </div>
@endsection
