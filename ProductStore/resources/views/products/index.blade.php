@extends('layouts.master')

@section('title', 'Products')

@section('content')
    <div class="container mt-4">
        <h2 class="text-center mb-4">Available Products</h2>

        @if(auth()->user()->role === 'employee' || auth()->user()->role === 'admin')
            <div class="text-end mb-3">
                <a href="{{ route('products.create') }}" class="btn btn-success">Add New Product</a>
            </div>
        @endif

        <div class="row">
            @foreach ($products as $product)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Product Image">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ $product->description ?? 'No description available.' }}</p>
                            <p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
                            <p><strong>Stock:</strong> 
                                <span class="badge bg-{{ $product->stock > 0 ? 'success' : 'danger' }}">
                                    {{ $product->stock > 0 ? $product->stock . ' Available' : 'Out of Stock' }}
                                </span>
                            </p>

                            @if(auth()->user()->role === 'customer' && $product->stock > 0)
                                <form action="{{ route('products.buy', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary w-100">Buy Now</button>
                                </form>
                            @endif
                        </div>

                        @if(auth()->user()->role === 'employee' || auth()->user()->role === 'admin')
                            <div class="card-footer text-center">
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete this product?');">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
@if(auth()->user()->role === 'customer' && $product->stock > 0)
    <form action="{{ route('products.buy', $product->id) }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary w-100">Buy Now</button>
    </form>
@endif

@if(auth()->user()->role === 'employee' || auth()->user()->role === 'admin')
    <div class="card-footer text-center">
        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">Edit</a>
        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline"
              onsubmit="return confirm('Are you sure you want to delete this product?');">
            @csrf
            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
        </form>
    </div>
@endif
