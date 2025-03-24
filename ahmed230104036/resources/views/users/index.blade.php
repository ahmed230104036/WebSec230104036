@extends('layouts.app')

@section('title', 'Manage Users')

@section('content')
<div class="container mt-4">
    <h2>Manage Users</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Credit</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role }}</td>
                <td>${{ $user->credit }}</td>
                <td>
                    @if(auth()->user()->isEmployee() && $user->role == 'Customer')
                        <form method="POST" action="{{ route('users.charge_credit', $user->id) }}">
                            @csrf
                            <input type="number" name="amount" class="form-control d-inline-block" style="width: 100px;" required>
                            <button type="submit" class="btn btn-sm btn-primary">Charge</button>
                        </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
