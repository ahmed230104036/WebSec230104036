@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="container mt-4">
    <h2>Welcome to Lab Exercises 2</h2>
    <p>Select an exercise to view:</p>
    <ul class="list-group">
        <li class="list-group-item"><a href="{{ url('/minitest') }}">MiniTest - Supermarket Bill</a></li>
        <li class="list-group-item"><a href="{{ url('/transcript') }}">Transcript - Student Grades</a></li>
        <li class="list-group-item"><a href="{{ url('/products') }}">Products - Catalog</a></li>
        <li class="list-group-item"><a href="{{ url('/calculator') }}">Calculator</a></li>
        <li class="list-group-item"><a href="{{ url('/gpa') }}">GPA Simulator</a></li>
    </ul>
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



























                    