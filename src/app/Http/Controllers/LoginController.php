<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // ここを追加
use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{
    public function showLoginForm()
    {
         return view('login')->withErrors(session()->get('errors'));
    }

    public function login(LoginRequest $request)
    {
        // バリデーションは LoginRequest により自動的に行われる
        $credentials = $request->only('email', 'password');
        $user = \App\Models\User::where('email', $request->email)->first();
    
        // パスワードの確認
        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            return redirect()->intended('/');
        }
    
        // 認証失敗時のエラーメッセージを表示
        return back()->withErrors([
            'email' => '入力された資格情報が登録されていません。',
        ])->withInput($request->only('email'));
    }
    
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        return redirect('/login');
    }


}
