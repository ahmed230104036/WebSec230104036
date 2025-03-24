@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="container">
    <h2>My Profile</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <tr>
            <th>Name:</th>
            <td>{{ auth()->user()->name }}</td>
        </tr>
        <tr>
            <th>Email:</th>
            <td>{{ auth()->user()->email }}</td>
        </tr>
        <tr>
            <th>Role:</th>
            <td>{{ auth()->user()->role }}</td>
        </tr>
    </table>

    <a href="{{ route('users.edit_profile') }}" class="btn btn-primary">Edit Profile</a>
</div>
@endsection
