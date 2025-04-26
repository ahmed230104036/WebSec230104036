@extends('layouts.app')

@section('title', 'Add New Role')

@section('content')
<div class="container">
    <h2>Add New Role</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('roles.store') }}">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Role Name:</label>
            <input type="text" class="form-control" name="name" required>
        </div>

        <button type="submit" class="btn btn-success">Create Role</button>
    </form>

    <a href="{{ route('roles.index') }}" class="btn btn-secondary mt-3">Back to Roles</a>
</div>
@endsection





















