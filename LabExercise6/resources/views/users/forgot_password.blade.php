@extends('layouts.master')
@section('title', 'Forgot Password')
@section('content')
<div class="d-flex justify-content-center">
  <div class="card m-4 col-sm-6">
    <div class="card-body">
      <h4 class="card-title">Forgot Password</h4>
      <form action="{{route('send_reset_password')}}" method="POST">
        @csrf
        <div class="form-group">
          @if(session('error'))
          <div class="alert alert-danger">
            <strong>Error!</strong> {{session('error')}}
          </div>
          @endif
          @if(session('success'))
          <div class="alert alert-success">
            <strong>Success!</strong> {{session('success')}}
          </div>
          @endif
          @foreach($errors->all() as $error)
          <div class="alert alert-danger">
            <strong>Error!</strong> {{$error}}
          </div>
          @endforeach
        </div>
        <div class="form-group mb-2">
          <label for="email" class="form-label">Email:</label>
          <input type="email" class="form-control" placeholder="email" name="email" required>
        </div>
        <div class="form-group mb-2">
          <button type="submit" class="btn btn-primary">Send Reset Link</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection 





































