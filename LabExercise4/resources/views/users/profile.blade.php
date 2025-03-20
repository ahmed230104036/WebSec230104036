@extends('layouts.app')

@section('title', 'User Profile')

@section('content')
    <div class="container">
        <h2>User Profile</h2>

        <div class="card">
            <div class="card-body">
                <p><strong>Name:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Admin:</strong> {{ $user->isAdmin() ? 'Yes' : 'No' }}</p>

                <div class="mt-3">
                    @if(auth()->user()->id === $user->id)
            
                        <a href="{{ route('users.change_own_password') }}" class="btn btn-warning">Change Password</a>
                    @endif

                    @if(auth()->user()->isAdmin())
                        
                        <a href="{{ route('users.change_password', $user->id) }}" class="btn btn-danger">Reset Password</a>
                    @endif

                    @if(auth()->user()->isAdmin() || auth()->user()->id === $user->id)
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">Edit Profile</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
