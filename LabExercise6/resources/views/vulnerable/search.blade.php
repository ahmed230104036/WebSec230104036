@extends('layouts.master')
@section('title', 'Vulnerable Search')
@section('content')
<div class="container">
    <h1>Vulnerable Search Example</h1>
    <p class="text-danger">Warning: This page contains intentional SQL injection vulnerabilities for educational purposes.</p>
    
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    Vulnerable Search (using DB::unprepared)
                </div>
                <div class="card-body">
                    <form action="{{ route('vulnerable.search') }}" method="GET">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="keywords" placeholder="Search products..." value="{{ $keywords ?? '' }}">
                            <button class="btn btn-outline-danger" type="submit">Search</button>
                        </div>
                        <small class="text-muted">Try SQL injection: ' OR '1'='1</small>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success text-white">
                    Secure Search (using prepared statements)
                </div>
                <div class="card-body">
                    <form action="{{ route('secure.search') }}" method="GET">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="keywords" placeholder="Search products..." value="{{ $keywords ?? '' }}">
                            <button class="btn btn-outline-success" type="submit">Search</button>
                        </div>
                        <small class="text-muted">Protected against SQL injection</small>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <h2>Search Results</h2>
    
    @if(count($products) > 0)
        <div class="row">
            @foreach($products as $product)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">{{ $product->code }} - {{ $product->model }}</h6>
                            <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                            <p class="card-text"><strong>Price:</strong> ${{ $product->price }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info">No products found matching your search criteria.</div>
    @endif
</div>
@endsection
