@extends('layouts.master')
@section('title', 'Welcome')
@section('content')
    <div class="card m-4">
      <div class="card-body">
        <h3>Welcome to Home Page</h3>
        <p class="mt-3">Check out our cryptography tools:</p>
        <a href="{{ route('crypto.simple') }}" class="btn btn-danger btn-lg mt-2">
            <i class="fas fa-lock"></i> Open Cryptography Tools
        </a>
      </div>
    </div>
@endsection
