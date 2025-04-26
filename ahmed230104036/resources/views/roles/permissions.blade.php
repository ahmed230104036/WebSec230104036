@extends('layouts.app')

@section('title', 'Edit Permissions for ' . $role->name)

@section('content')
<div class="container">
    <h2>Edit Permissions for {{ $role->name }}</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('roles.update_permissions', $role->id) }}">
        @csrf

        <div class="mb-3">
            @foreach($permissions as $permission)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                        {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                    <label class="form-check-label">{{ $permission->name }}</label>
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary">Update Permissions</button>
    </form>

    <a href="{{ route('roles.index') }}" class="btn btn-secondary mt-3">Back to Roles</a>
</div>
@endsection


























