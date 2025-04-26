@extends('layouts.menu')

@section('content')
<div class="container mt-4">
    <h2>Reset Password</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('update_new_password', $user->id) }}" method="post">
        {{ csrf_field() }}

        <div class="form-group mb-2">
            <label for="new_password">New Password:</label>
            <input type="password" class="form-control" name="new_password" required>
        </div>

        <div class="form-group mb-2">
            <label for="confirm_password">Confirm New Password:</label>
            <input type="password" class="form-control" name="confirm_password" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Password</button>
    </form>
</div>
@endsection





































