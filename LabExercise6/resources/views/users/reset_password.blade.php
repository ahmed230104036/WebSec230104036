@extends('layouts.master')
@section('title', 'Reset Password')
@section('content')
<div class="d-flex justify-content-center">
  <div class="card m-4 col-sm-6">
    <div class="card-body">
      <form action="{{route('update_password')}}" method="POST">
        @csrf
        <input type="hidden" name="token" value="{{$token}}">
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
          <label for="password" class="form-label">New Password:</label>
          <input type="password" class="form-control" placeholder="New Password" name="password" required>
        </div>
        <div class="form-group mb-2">
          <label for="password_confirmation" class="form-label">Confirm New Password:</label>
          <input type="password" class="form-control" placeholder="Confirm New Password" name="password_confirmation" required>
        </div>
        <div class="form-group mb-2">
          <button type="submit" class="btn btn-primary">Reset Password</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection 