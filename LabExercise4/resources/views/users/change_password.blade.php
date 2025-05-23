@extends('layouts.app')

@section('title', 'Change Password')

@section('content')
    <div class="container">
        <h2>Change Password</h2>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('users.update_own_password') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="old_password" class="form-label">Old Password:</label>
                <input type="password" class="form-control" name="old_password" required>
            </div>

            <div class="mb-3">
                <label for="new_password" class="form-label">New Password:</label>
                <input type="password" class="form-control" name="new_password" required>
            </div>

            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm New Password:</label>
                <input type="password" class="form-control" name="confirm_password" required>
            </div>

            <button type="submit" class="btn btn-primary">Update Password</button>
        </form>
    </div>
@endsection




























