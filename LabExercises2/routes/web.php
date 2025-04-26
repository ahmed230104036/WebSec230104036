<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', [UserController::class, 'index'])->name('home');


//MiniTest (Supermarket Bill)
Route::get('/minitest', function () {
    $bill = [
        ['item' => 'Milk', 'quantity' => 2, 'price' => 20],
        ['item' => 'Bread', 'quantity' => 1, 'price' => 10],
        ['item' => 'Eggs', 'quantity' => 12, 'price' => 30],
    ];
    return view('minitest', compact('bill'));
});

//Transcript
Route::get('/transcript', function () {
    $transcript = [
        ['course' => 'Mathematics', 'grade' => 'A', 'credits' => 3],
        ['course' => 'Physics', 'grade' => 'B+', 'credits' => 4],
        ['course' => 'Computer Science', 'grade' => 'A-', 'credits' => 3],
    ];
    return view('transcript', compact('transcript'));
});

//Products
Route::get('/products', function () {
    $products = [
        ['name' => 'Laptop', 'image' => 'laptop.jpg', 'price' => 1000, 'description' => 'Powerful laptop'],
        ['name' => 'Phone', 'image' => 'phone.jpg', 'price' => 500, 'description' => 'Smartphone with best camera'],
        ['name' => 'Headphones', 'image' => 'headphones.jpg', 'price' => 150, 'description' => 'Noise-cancelling headphones'],
    ];
    return view('products', compact('products'));
});

//Calculator
Route::get('/calculator', function () {
    return view('calculator');
});
Route::post('/calculator', function (\Illuminate\Http\Request $request) {
    $num1 = $request->input('num1');
    $num2 = $request->input('num2');
    $operation = $request->input('operation');
    $result = 0;

    switch ($operation) {
        case '+': $result = $num1 + $num2; break;
        case '-': $result = $num1 - $num2; break;
        case '*': $result = $num1 * $num2; break;
        case '/': $result = $num2 != 0 ? $num1 / $num2 : 'Error: Division by zero'; break;
    }

    return view('calculator', compact('num1', 'num2', 'operation', 'result'));
});

// GPA Simulator
Route::get('/gpa', function () {
    $courses = [
        ['code' => 'CS101', 'title' => 'Computer Science Basics', 'credits' => 3],
        ['code' => 'MATH202', 'title' => 'Advanced Mathematics', 'credits' => 4],
        ['code' => 'PHYS303', 'title' => 'Physics for Engineers', 'credits' => 3],
    ];
    return view('gpa', compact('courses'));
});





















