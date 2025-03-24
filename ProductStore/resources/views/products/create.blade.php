@extends('layouts.master')

@section('title', 'Add Product')

@section('content')
    <div class="container mt-5">
        <h2 class="text-center">Add New Product</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Product Name:</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description:</label>
                <textarea name="description" id="description" class="form-control"></textarea>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Price:</label>
                <input type="number" name="price" id="price" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="stock" class="form-label">Stock:</label>
                <input type="number" name="stock" id="stock" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Add Product</button>
        </form>
    </div>
@endsection
