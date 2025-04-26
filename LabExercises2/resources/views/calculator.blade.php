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
<!-- <option value="4.3">A+ (4.3)</option>
                        <option value="4.0">A (4.0)</option>
                        <option value="3.7">A- (3.7)</option>
                        <option value="3.3">B+ (3.3)</option>
                        <option value="3.0">B (3.0)</option>
                        <option value="2.7">B- (2.7)</option>
                        <option value="2.3">C+ (2.3)</option>
                        <option value="2.0">C (2.0)</option>
                        <option value="1.7">C- (1.7)</option>
                        <option value="1.3">D+ (1.3)</option>
                        <option value="1.0">D (1.0)</option>
                        <option value="0">F (0.0)</option>
                    </select> -->