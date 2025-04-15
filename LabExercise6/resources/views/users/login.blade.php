@extends('layouts.master')
@section('title', 'Login')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Login</h4>
            </div>
            <div class="card-body">
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </div>
                </form>
                <div class="text-center mb-3">
                    <a href="{{ route('forgot_password') }}">Forgot Password?</a>
                </div>
                <div class="form-group mb-2">
                    <a href="{{ route('login_with_google') }}" class="btn btn-danger w-100">
                        <i class="fab fa-google me-2"></i>Login with Google
                    </a>
                </div>
                <div class="form-group mb-2">
                    <a href="{{ route('login_with_facebook') }}" class="btn btn-primary w-100">
                        <i class="fab fa-facebook me-2"></i>Login with Facebook
                    </a>
                </div>
                <div class="form-group mb-2">
                    <a href="{{ route('login_with_microsoft') }}" class="btn btn-info w-100">
                        <i class="fab fa-microsoft me-2"></i>Login with Microsoft
                    </a>
                </div>
                <div class="form-group mb-2">
                    <a href="{{ route('login_with_linkedin') }}" class="btn btn-primary w-100">
                        <i class="fab fa-linkedin me-2"></i>Login with LinkedIn
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
