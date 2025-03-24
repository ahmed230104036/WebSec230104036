@extends('layouts.master')

@section('title', 'Profile')

@section('content')
    <h2>User Profile</h2>
    <table class="table">
        <tr>
            <th>Name:</th>
            <td>{{ $user->name }}</td>
        </tr>
        <tr>
            <th>Email:</th>
            <td>{{ $user->email }}</td>
        </tr>
        <tr>
            <th>Role:</th>
            <td>{{ ucfirst($user->role) }}</td>
        </tr>
        <tr>
            <th>Credit:</th>
            <td>${{ number_format($user->credit, 2) }}</td>
        </tr>
    </table>
@endsection
