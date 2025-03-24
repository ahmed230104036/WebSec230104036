@extends('layouts.master')

@section('title', 'Insufficient Credit')

@section('content')
    <div class="container text-center mt-5">
        <h2 class="text-danger">Insufficient Credit</h2>
        <p>You do not have enough credit to complete this purchase.</p>
        <a href="{{ route('products.index') }}" class="btn btn-primary">Back to Products</a>
    </div>
@endsection
