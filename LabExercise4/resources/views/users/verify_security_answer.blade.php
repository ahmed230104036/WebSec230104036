@extends('layouts.app')

@section('title', 'Security Question')

@section('content')
    <div class="container">
        <h2>Security Question</h2>

        <form action="{{ route('reset_password', $user->id) }}" method="POST">
            @csrf
            <p><strong>Security Question:</strong> {{ $user->security_question }}</p>

            <div class="mb-3">
                <label for="security_answer" class="form-label">Your Answer:</label>
                <input type="text" class="form-control" name="security_answer" required>
            </div>

            <button type="submit" class="btn btn-primary">Verify</button>
        </form>
    </div>
@endsection































