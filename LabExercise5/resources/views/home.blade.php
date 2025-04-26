@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="container">
    <h1>Hello</h1>

    @auth
        @if(auth()->user()->role == 'Admin' || auth()->user()->role == 'Employee')
            <a href="{{ route('users.index') }}" class="btn btn-primary">Manage Users</a>
        @endif

        <a href="{{ route('users.profile') }}" class="btn btn-secondary">My Profile</a>

        <form action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            <button class="btn btn-danger">Logout</button>
        </form>
    @else
        <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
        <a href="{{ route('register') }}" class="btn btn-secondary">Register</a>
    @endauth
</div>
@endsection














































