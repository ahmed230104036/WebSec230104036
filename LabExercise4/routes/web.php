<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\UsersController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\ForgotPasswordController;

Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('forgot_password');
Route::post('/forgot-password', [ForgotPasswordController::class, 'verifySecurityAnswer'])->name('verify_security_answer');
Route::get('/reset-password/{user}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset_password');
Route::post('/reset-password/{user}', [ForgotPasswordController::class, 'updatePassword'])->name('update_new_password');



Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');


Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('register', [UsersController::class, 'register'])->name('register');
Route::post('register', [UsersController::class, 'doRegister'])->name('do_register');

Route::get('login', [UsersController::class, 'login'])->name('login');
Route::post('login', [UsersController::class, 'doLogin'])->name('do_login');
Route::get('logout', [UsersController::class, 'doLogout'])->name('logout');
Route::get('profile/{user}', [UsersController::class, 'profile'])->name('profile');

Route::get('/users', [UsersController::class, 'index'])->name('users.index');
Route::get('/users/{user}', [UsersController::class, 'show'])->name('users.show');
Route::delete('/users/{user}', [UsersController::class, 'destroy'])->name('users.destroy');
Route::get('/users/{user}/edit', [UsersController::class, 'edit'])->name('users.edit');
Route::put('/users/{user}', [UsersController::class, 'update'])->name('users.update');
Route::get('/users/{id}', [UsersController::class, 'profile'])->name('users.profile');

Route::middleware(['auth'])->group(function () {
    Route::get('/change-password', [UserController::class, 'showChangePasswordForm'])->name('users.change_own_password');
    Route::post('/change-password', [UserController::class, 'updateOwnPassword'])->name('users.update_own_password');
    
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/users/{user}/change-password', [UserController::class, 'showChangePasswordFormAdmin'])->name('users.change_password');
    Route::post('/users/{user}/update-password', [UserController::class, 'updatePasswordAdmin'])->name('users.update_password');
});


Route::get('forgot-password', [UsersController::class, 'forgotPassword'])->name('forgot_password');
Route::post('forgot-password', [UsersController::class, 'verifySecurityAnswer'])->name('verify_security_answer');
Route::get('reset-password/{user}', [UsersController::class, 'resetPassword'])->name('reset_password');
Route::post('reset-password/{user}', [UsersController::class, 'updatePassword'])->name('update_new_password');

Route::middleware(['auth'])->group(function () {
    Route::get('/users/{user}/change-password', [UserController::class, 'showChangePasswordForm'])->name('users.change_password');
    Route::post('/users/{user}/update-password', [UserController::class, 'updatePassword'])->name('users.update_password');
});


