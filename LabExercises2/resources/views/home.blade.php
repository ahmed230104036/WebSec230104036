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






















































