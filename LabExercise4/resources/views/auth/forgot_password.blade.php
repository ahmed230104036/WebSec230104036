@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')
    <div class="container">
        <h2>Forgot Password</h2>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('verify_security_answer') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Enter your Email:</label>
                <input type="email" class="form-control" name="email" required>
            </div>

            <button type="submit" class="btn btn-primary">Next</button>
        </form>
    </div>
@endsection
