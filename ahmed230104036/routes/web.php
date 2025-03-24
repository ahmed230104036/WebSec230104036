<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/', function () {
    return view('home');
})->middleware('auth')->name('home');

Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::middleware(['auth'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/profile', [UserController::class, 'profile'])->name('users.profile');

    Route::middleware(['admin'])->group(function () {
        Route::get('/users/create-employee', [UserController::class, 'createEmployee'])->name('users.create_employee');
        Route::post('/users/store-employee', [UserController::class, 'storeEmployee'])->name('users.store_employee');
    });

    Route::middleware(['employee'])->group(function () {
        Route::post('/users/{user}/charge-credit', [UserController::class, 'chargeCredit'])->name('users.charge_credit');

        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    });

    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::middleware(['customer'])->group(function () {
        Route::post('/products/{product}/buy', [ProductController::class, 'buy'])->name('products.buy');
    });
});
