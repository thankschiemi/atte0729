<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
    
            // Auth::attempt の結果をログに出力
        $result = Auth::attempt($credentials);
        Log::info('Auth attempt result', ['result' => $result, 'email' => $credentials['email']]);
    
        if (Auth::attempt($credentials)) {
            // ログイン成功時
            Log::info('ログイン成功', ['email' => $credentials['email']]);
            return redirect()->intended('/');
        } else {
            // ログイン失敗時
            Log::error('ログイン失敗', ['email' => $credentials['email'], 'reason' => '認証に失敗しました。']);

            return redirect()->back()->withErrors(['email' => '認証情報が正しくありません']);
        }
    }
    
    
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}




