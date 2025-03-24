@extends('layouts.master')

@section('title', 'Home')

@section('content')
    <div class="text-center">
        <h1>Welcome to ProductStore</h1>
        <p>Manage and purchase products efficiently.</p>
        @auth
            <a href="{{ route('products.index') }}" class="btn btn-primary">View Products</a>
        @else
            <a href="{{ route('login') }}" class="btn btn-success">Login to continue</a>
        @endauth
    </div>
@endsection
