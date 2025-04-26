@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')
    <div class="container">
        <h2>Forgot Password</h2>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('verify_security_answer') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email_or_mobile" class="form-label">Enter your Email or Mobile Number:</label>
                <input type="text" class="form-control" name="email_or_mobile" required>
            </div>

            <button type="submit" class="btn btn-primary">Next</button>
        </form>
    </div>
@endsection





























