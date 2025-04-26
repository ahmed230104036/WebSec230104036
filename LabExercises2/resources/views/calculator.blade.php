@extends('layouts.app')

@section('title', 'Calculator')

@section('content')
<div class="container mt-4">
    <h2>Simple Calculator</h2>
    <form method="POST" action="{{ url('/calculator') }}">
        @csrf
        <div class="mb-3">
            <input type="number" name="num1" class="form-control" placeholder="Enter first number" required>
        </div>
        <div class="mb-3">
            <input type="number" name="num2" class="form-control" placeholder="Enter second number" required>
        </div>
        <div class="mb-3">
            <select name="operation" class="form-control">
                <option value="+">Addition (+)</option>
                <option value="-">Subtraction (-)</option>
                <option value="*">Multiplication (*)</option>
                <option value="/">Division (/)</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Calculate</button>
    </form>

    @isset($result)
        <h3 class="mt-3">Result: {{ $result }}</h3>
    @endisset
</div>
@endsection
















































