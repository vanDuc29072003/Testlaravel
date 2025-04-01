<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Hiển thị trang đăng nhập
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');

// Xử lý đăng nhập
Route::post('/login', [AuthController::class, 'login']);

// Đăng xuất
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Trang cần đăng nhập mới truy cập được
Route::get('/may', function () {
    return view('may');
})->middleware('auth');

     
