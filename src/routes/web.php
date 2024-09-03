<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\StampController;
use App\Http\Controllers\AttendanceController;

// 会員登録ページ
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// ログインページ
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// 打刻ページ（ログインが必要）
Route::get('/', [StampController::class, 'index'])->middleware('auth');

// 各ボタンの状態

Route::post('/start-work', [AttendanceController::class, 'startWork'])->name('attendance.startWork');
Route::post('/end-work', [AttendanceController::class, 'endWork'])->name('attendance.endWork');
Route::post('/start-break', [AttendanceController::class, 'startBreak'])->name('attendance.startBreak');
Route::post('/end-break', [AttendanceController::class, 'endBreak'])->name('attendance.endBreak');

Route::get('/', [StampController::class, 'index'])->middleware('auth');

Route::get('/attendance', [AttendanceController::class, 'index']);