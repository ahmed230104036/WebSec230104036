@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <div class="container">
        <h2>Register</h2>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <label for="mobile_number" class="form-label">Mobile Number (Optional):</label>
                <input type="text" class="form-control" name="mobile_number" value="{{ old('mobile_number') }}">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" name="password" required>
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password:</label>
                <input type="password" class="form-control" name="password_confirmation" required>
            </div>

            <div class="mb-3">
                <label for="security_question" class="form-label">Security Question:</label>
                <input type="text" class="form-control" name="security_question" required>
            </div>

            <div class="mb-3">
                <label for="security_answer" class="form-label">Security Answer:</label>
                <input type="text" class="form-control" name="security_answer" required>
            </div>

            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>
@endsection
