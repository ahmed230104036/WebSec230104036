@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div class="container">
        <h2>Login</h2>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" name="email" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" name="password" required>
            </div>

            <button type="submit" class="btn btn-primary">Login</button>
        </form>

        <a href="{{ route('forgot_password') }}" class="text-primary mt-3 d-block">Forgot Password?</a>
    </div>
@endsection
