@extends('layouts.master')
@section('title', 'Add Review')
@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4>Add Review for {{ $product->name }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('reviews.store', $product->id) }}" method="POST">
                        @csrf
                        
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        
                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger">
                                <strong>Error!</strong> {{ $error }}
                            </div>
                        @endforeach
                        
                        <div class="mb-3">
                            <label for="rating" class="form-label">Rating (1-5 stars)</label>
                            <select name="rating" id="rating" class="form-control" required>
                                <option value="">Select Rating</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="comment" class="form-label">Your Review</label>
                            <textarea name="comment" id="comment" rows="5" class="form-control" required></textarea>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Submit Review</button>
                            <a href="{{ route('products_list') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
