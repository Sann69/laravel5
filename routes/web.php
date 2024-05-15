<?php

use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

// Proses tambah produk
Route::post('/{user}/post-request', [UserController::class, 'postRequest'])->name('postRequest');

// Form tambah produk
Route::get('/{user}/tambah-product', [UserController::class, 'handleRequest'])->name('form_product');

// Tampil semua produk
Route::get('/products', [UserController::class, 'getProduct'])->name('get_product');

// Form edit produk
Route::get('/{user}/product/{product}', [UserController::class, 'editProduct'])->name('edit_product');

// Proses edit produk
Route::put('/{user}/product/{product}/update', [UserController::class, 'updateProduct'])->name('update_product');

// Delete produk
Route::post('/{user}/product/{product}/delete', [UserController::class, 'deleteProduct'])->name('delete_product');

// Halaman profil
Route::get('/profile/{user}', [UserController::class, 'getProfile'])->name('get_profile');

// Halaman admin
Route::get('/admin/{user}/list-products', [UserController::class, 'getAdmin'])->name('admin_page');

// Autentikasi
Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('/register-user', [UserController::class, 'registerUser'])->name('register_user');
Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('/login', [UserController::class, 'loginUser'])->name('login_user');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

// Dashboard
Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard')->middleware(['auth', 'role:superadmin|user']);

// Socialite Google Login
Route::get('/login/google', [UserController::class, 'loginGoogle'])->name('login_google');
Route::get('/login/google/callback', [UserController::class, 'loginGoogleCallback'])->name('callback_google');