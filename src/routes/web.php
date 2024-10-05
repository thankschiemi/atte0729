<?php

use Illuminate\Support\Facades\Route;
use Carbon\Carbon;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\StampController;
use App\Http\Controllers\AttendanceController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MemberController;
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
use App\Http\Controllers\FileUploadController;
=======
>>>>>>> e8d0bf6debbee7ba0aa5fca3bca54987780d9922
=======
>>>>>>> e8d0bf6debbee7ba0aa5fca3bca54987780d9922
=======
>>>>>>> e8d0bf6debbee7ba0aa5fca3bca54987780d9922
=======
>>>>>>> e8d0bf6debbee7ba0aa5fca3bca54987780d9922

// web ミドルウェアを適用したルートグループ
Route::middleware(['web'])->group(function () {
    Auth::routes(['verify' => true]);  // メール認証を有効にする

    // 会員登録ページ
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    // ログインページ
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // ログアウトルート（認証済みのみ）
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

    // 打刻ページ（ログイン + メール認証済みが必要）
    Route::get('/', [StampController::class, 'index'])->middleware(['auth', 'verified']);

    // 各ボタンの状態
    Route::post('/start-work', [AttendanceController::class, 'startWork'])->name('attendance.startWork')->middleware(['auth', 'verified']);
    Route::post('/end-work', [AttendanceController::class, 'endWork'])->name('attendance.endWork')->middleware(['auth', 'verified']);
    Route::post('/start-break', [AttendanceController::class, 'startBreak'])->name('attendance.startBreak')->middleware(['auth', 'verified']);
    Route::post('/end-break', [AttendanceController::class, 'endBreak'])->name('attendance.endBreak')->middleware(['auth', 'verified']);

    // 日付一覧ページ（ログイン + メール認証済みが必要）
    Route::get('/attendance/{date?}', [AttendanceController::class, 'showByDate'])->name('attendance.date')->middleware(['auth', 'verified']);
    Route::get('/attendance', [AttendanceController::class, 'index'])->middleware(['auth', 'verified']);

    // ダッシュボード
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    // ユーザー一覧ページ
    Route::get('/members', [MemberController::class, 'index'])->name('members.index')->middleware(['auth', 'verified']);

  

    Route::post('/members', [MemberController::class, 'store'])->name('members.store');


    // 勤怠表（年と月の指定をオプションで受け付ける）
    Route::get('/timesheets/{userId}/{yearMonth?}', [AttendanceController::class, 'showTimesheet'])->name('attendance.timesheet');

    // 自分の勤怠表にリダイレクトするルート
    Route::get('/timesheets', function () {
        //現在の年月を取得
        $yearMonth = Carbon::now()->format('Y-m');
        //リダイレクト時に userId と yearMonth を含める
        return redirect()->route('attendance.timesheet', ['userId' => Auth::id(), 'yearMonth' => $yearMonth]);
    })->middleware(['auth', 'verified']);
});

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
Route::post('/upload', [FileUploadController::class, 'upload']);
=======
=======
>>>>>>> e8d0bf6debbee7ba0aa5fca3bca54987780d9922
=======
>>>>>>> e8d0bf6debbee7ba0aa5fca3bca54987780d9922
=======
>>>>>>> e8d0bf6debbee7ba0aa5fca3bca54987780d9922

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> e8d0bf6debbee7ba0aa5fca3bca54987780d9922
=======
>>>>>>> e8d0bf6debbee7ba0aa5fca3bca54987780d9922
=======
>>>>>>> e8d0bf6debbee7ba0aa5fca3bca54987780d9922
=======
>>>>>>> e8d0bf6debbee7ba0aa5fca3bca54987780d9922
