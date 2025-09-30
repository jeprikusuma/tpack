<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CKEditorController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/dosen.php';
require __DIR__.'/mahasiswa.php';

Route::get('/', function () {
    return view('index');
});

Route::get('/content', function () {
    return view('content');
});

Route::get('/partner', function () {
    return view('partner');
});

Route::get('/workflow', function () {
    return view('workflow');
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');



Route::post('/upload-image', [CKEditorController::class, 'store'])->name('upload.image');
