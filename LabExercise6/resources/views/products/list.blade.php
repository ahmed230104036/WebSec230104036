@extends('layouts.master')
@section('title', 'Test Page')
@section('content')
<div class="row mt-2">
    <div class="col col-10">
        <h1>Products</h1>
    </div>
    <div class="col col-2">
        @can('add_products')
        <a href="{{route('products_edit')}}" class="btn btn-success form-control">Add Product</a>
        @endcan
    </div>
</div>

@auth
<div class="card mb-3">
    <div class="card-header bg-info text-white">
        User Information
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Welcome:</strong> <span id="user-name">{!! auth()->user()->name !!}</span></p>
            </div>
            <div class="col-md-6">
                <p><strong>Credit Card:</strong> <span id="user-credit">{!! auth()->user()->credit_card !!}</span></p>
            </div>
        </div>
        <div id="search-history"></div>
    </div>
</div>
@endauth
<form id="search-form">
    <div class="row">
        <div class="col col-sm-2">
            <input name="keywords" id="search-keywords" type="text" class="form-control" placeholder="Search Keywords" value="{{ request()->keywords }}" />
        </div>
        <div class="col col-sm-2">
            <input name="min_price" type="numeric" class="form-control" placeholder="Min Price" value="{{ request()->min_price }}"/>
        </div>
        <div class="col col-sm-2">
            <input name="max_price" type="numeric" class="form-control" placeholder="Max Price" value="{{ request()->max_price }}"/>
        </div>
        <div class="col col-sm-2">
            <select name="order_by" class="form-select">
                <option value="" {{ request()->order_by==""?"selected":"" }} disabled>Order By</option>
                <option value="name" {{ request()->order_by=="name"?"selected":"" }}>Name</option>
                <option value="price" {{ request()->order_by=="price"?"selected":"" }}>Price</option>
            </select>
        </div>
        <div class="col col-sm-2">
            <select name="order_direction" class="form-select">
                <option value="" {{ request()->order_direction==""?"selected":"" }} disabled>Order Direction</option>
                <option value="ASC" {{ request()->order_direction=="ASC"?"selected":"" }}>ASC</option>
                <option value="DESC" {{ request()->order_direction=="DESC"?"selected":"" }}>DESC</option>
            </select>
        </div>
        <div class="col col-sm-1">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        <div class="col col-sm-1">
            <button type="reset" class="btn btn-danger">Reset</button>
        </div>
    </div>
</form>

<!-- Vulnerable: Directly outputting search keywords without sanitization -->
@if(isset($searchKeywords) && !empty($searchKeywords))
<div class="alert alert-info mt-3">
    <h4>Search Results for: {!! $searchKeywords !!}</h4>
</div>
@endif


@foreach($products as $product)
    <div class="card mt-2">
        <div class="card-body">
            <div class="row">
                <div class="col col-sm-12 col-lg-4">
                    <img src="{{asset("images/$product->photo")}}" class="img-thumbnail" alt="{{$product->name}}" width="100%">
                </div>
                <div class="col col-sm-12 col-lg-8 mt-3">
                    <div class="row mb-2">
					    <div class="col-6">
					        <h3>{{$product->name}}</h3>
					    </div>
					    <div class="col col-2">
                            @auth
					        <a href="{{route('reviews.create', $product->id)}}" class="btn btn-primary form-control">Add Review</a>
                            @endauth
					    </div>
					    <div class="col col-2">
                            @can('edit_products')
					        <a href="{{route('products_edit', $product->id)}}" class="btn btn-success form-control">Edit</a>
                            @endcan
					    </div>
					    <div class="col col-2">
                            @can('delete_products')
					        <a href="{{route('products_delete', $product->id)}}" class="btn btn-danger form-control">Delete</a>
                            @endcan
					    </div>
					</div>

                    <table class="table table-striped">
                        <tr><th width="20%">Name</th><td>{{$product->name}}</td></tr>
                        <tr><th>Model</th><td>{{$product->model}}</td></tr>
                        <tr><th>Code</th><td>{{$product->code}}</td></tr>
                        <tr><th>Price</th><td>{{$product->price}}</td>
                        <tr><th>Description</th><td>{{$product->description}}</td></tr>
                    </table>

                
                    <div class="mt-4">
                        <h4>Customer Reviews</h4>
                        @if($product->reviews->count() > 0)
                            @foreach($product->reviews as $review)
                                <div class="card mb-2">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <h5 class="card-title">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $review->rating)
                                                        <i class="fas fa-star text-warning"></i>
                                                    @else
                                                        <i class="far fa-star text-warning"></i>
                                                    @endif
                                                @endfor
                                            </h5>
                                        </div>
                                        <h6 class="card-subtitle mb-2 text-muted">By: {{ $review->user->name }}</h6>
                                        <p class="card-text">{{ $review->comment }}</p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted">No reviews yet. Be the first to review this product!</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
<script>
function getUrlParameter(name) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    var results = regex.exec(location.search);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
}

document.addEventListener('DOMContentLoaded', function() {
    var searchTerm = getUrlParameter('keywords');

    if (searchTerm) {
        var historyDiv = document.getElementById('search-history');
        if (historyDiv) {
            var searchItem = document.createElement('div');
            searchItem.innerHTML = '<p>Recent search: ' + searchTerm + '</p>';
            historyDiv.appendChild(searchItem);
        }
    }

    document.getElementById('search-form').addEventListener('submit', function(e) {
        var keywords = document.getElementById('search-keywords').value;
        logSearchActivity(keywords);
    });
});

function logSearchActivity(keywords) {
    fetch('/collect?activity=search&keywords=' + encodeURIComponent(keywords))
        .then(response => response.json())
        .then(data => console.log('Activity logged:', data))
        .catch(error => console.error('Error logging activity:', error));
}

/
</script>
</script>
@endsection





































