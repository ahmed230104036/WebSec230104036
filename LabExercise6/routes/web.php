<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\ProductsController;
use App\Http\Controllers\Web\UsersController;
use App\Http\Controllers\Web\VulnerableController;
use App\Http\Controllers\Web\CollectController;

Route::get('register', [UsersController::class, 'register'])->name('register');
Route::post('register', [UsersController::class, 'doRegister'])->name('do_register');
Route::get('login', [UsersController::class, 'login'])->name('login');
Route::post('login', [UsersController::class, 'doLogin'])->name('do_login');
Route::get('logout', [UsersController::class, 'doLogout'])->name('do_logout');
Route::get('users', [UsersController::class, 'list'])->name('users');
Route::get('profile/{user?}', [UsersController::class, 'profile'])->name('profile');
Route::get('users/edit/{user?}', [UsersController::class, 'edit'])->name('users_edit');
Route::post('users/save/{user}', [UsersController::class, 'save'])->name('users_save');
Route::get('users/delete/{user}', [UsersController::class, 'delete'])->name('users_delete');
Route::get('users/edit_password/{user?}', [UsersController::class, 'editPassword'])->name('edit_password');
Route::post('users/save_password/{user}', [UsersController::class, 'savePassword'])->name('save_password');
Route::get('verify', [UsersController::class, 'verify'])->name('verify');
Route::get('/auth/google',
[UsersController::class, 'redirectToGoogle'])
->name('login_with_google');

Route::get('/auth/google/callback',
[UsersController::class, 'handleGoogleCallback']);

Route::get('/auth/facebook', [UsersController::class, 'redirectToFacebook'])->name('login_with_facebook');
Route::get('/auth/facebook/callback', [UsersController::class, 'handleFacebookCallback']);

Route::get('/auth/microsoft', [UsersController::class, 'redirectToMicrosoft'])->name('login_with_microsoft');
Route::get('/auth/microsoft/callback', [UsersController::class, 'handleMicrosoftCallback']);

Route::get('/auth/linkedin', [UsersController::class, 'redirectToLinkedIn'])->name('login_with_linkedin');
Route::get('/auth/linkedin/callback', [UsersController::class, 'handleLinkedInCallback']);

Route::get('forgot-password', [UsersController::class, 'forgotPassword'])->name('forgot_password');
Route::post('send-reset-password', [UsersController::class, 'sendResetPassword'])->name('send_reset_password');
Route::get('reset-password/{token}', [UsersController::class, 'showResetPasswordForm'])->name('reset_password');
Route::post('update-password', [UsersController::class, 'updatePassword'])->name('update_password');

Route::get('products', [ProductsController::class, 'list'])->name('products_list');
Route::get('products/edit/{product?}', [ProductsController::class, 'edit'])->name('products_edit');
Route::post('products/save/{product?}', [ProductsController::class, 'save'])->name('products_save');
Route::get('products/delete/{product}', [ProductsController::class, 'delete'])->name('products_delete');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/multable', function (Request $request) {
    $j = $request->number??5;
    $msg = $request->msg;
    return view('multable', compact("j", "msg"));
});

Route::get('/even', function () {
    return view('even');
});

Route::get('/prime', function () {
    return view('prime');
});

Route::get('/test', function () {
    return view('test');
});

// Vulnerable routes for SQL injection demonstration
Route::get('/vulnerable/search', [VulnerableController::class, 'vulnerableSearch'])->name('vulnerable.search');
Route::get('/secure/search', [VulnerableController::class, 'secureSearch'])->name('secure.search');
Route::get('/unprepared/example', [VulnerableController::class, 'safeUnprepared'])->name('unprepared.example');

// Data collection endpoint for XSS attacks
Route::get('/collect', [CollectController::class, 'collect'])->name('collect');

// XSS demonstration page
Route::get('/xss-demo', function () {
    return view('xss_demo');
})->name('xss_demo');

