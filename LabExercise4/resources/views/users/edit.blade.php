@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
    <div class="container">
        <h2>Edit User</h2>

        <form method="POST" action="{{ route('users.update', $user->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">New Password (Optional):</label>
                <input type="password" class="form-control" name="password">
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm New Password:</label>
                <input type="password" class="form-control" name="password_confirmation">
            </div>

            <button type="submit" class="btn btn-primary">Update User</button>
        </form>
    </div>
@endsection
