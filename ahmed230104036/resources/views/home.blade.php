@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container mt-4">
    <h2>Welcome, {{ auth()->user()->name }}</h2>
    
    <p>Your Role: <strong>{{ auth()->user()->role }}</strong></p>
    <p>Your Credit: <strong>${{ auth()->user()->credit }}</strong></p>

    <hr>

    @if(auth()->user()->isCustomer())
        <h3>Customer Options</h3>
        <ul class="list-group">
            <li class="list-group-item"><a href="{{ route('products.index') }}">View & Buy Products</a></li>
            <li class="list-group-item"><a href="{{ route('users.profile') }}">View Profile</a></li>
        </ul>
    @endif

    @if(auth()->user()->isEmployee())
        <h3>Employee Options</h3>
        <ul class="list-group">
            <li class="list-group-item"><a href="{{ route('products.create') }}">Add New Product</a></li>
            <li class="list-group-item"><a href="{{ route('users.index') }}">Manage Customers & Charge Credit</a></li>
        </ul>
    @endif

    @if(auth()->user()->isAdmin())
        <h3>Admin Options</h3>
        <ul class="list-group">
            <li class="list-group-item"><a href="{{ route('users.create_employee') }}">Add New Employee</a></li>
            <li class="list-group-item"><a href="{{ route('users.index') }}">Manage All Users</a></li>
        </ul>
    @endif
</div>
@endsection




























