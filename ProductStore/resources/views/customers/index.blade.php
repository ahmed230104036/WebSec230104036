@extends('layouts.master')

@section('title', 'Manage Customers')

@section('content')
    <div class="container mt-4">
        <h2 class="text-center">Customers List</h2>

        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Credit</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $customer)
                <tr>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>${{ number_format($customer->credit, 2) }}</td>
                    <td>
                        <form action="{{ route('customers.addCredit', $customer->id) }}" method="POST" class="d-inline">
                            @csrf
                            <input type="number" name="amount" class="form-control d-inline w-50" min="1" required>
                            <button type="submit" class="btn btn-success btn-sm">Add Credit</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
