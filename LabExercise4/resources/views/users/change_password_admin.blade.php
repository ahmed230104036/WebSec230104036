@extends('layouts.app')

@section('title', 'Change User Password')

@section('content')
    <div class="container">
        <h2>Change Password for {{ $user->name }}</h2>

        <form action="{{ route('users.update_password', $user->id) }}" method="POST">
            @csrf

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




































































































