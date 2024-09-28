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
        
        // Auth::attempt の結果をログに出力 (コメントアウト済み)
        $result = Auth::attempt($credentials);
        // Log::info('Auth attempt result', ['result' => $result, 'email' => $credentials['email']]);

        if ($result) { // ログイン成功時の処理
            // Log::info('ログイン成功', ['email' => $credentials['email']]);
            return redirect()->intended('/'); // デフォルトの遷移先（メインページなど）
        } else {
            // ログイン失敗時の処理
            // Log::error('ログイン失敗', ['email' => $credentials['email'], 'reason' => '認証に失敗しました。']);
            return redirect()->back()->withErrors(['email' => '認証情報が正しくありません']);
        }
    }
    
    public function logout(Request $request)
    {
        Auth::logout(); // ログアウト処理
        $request->session()->invalidate(); // セッションを無効化
        $request->session()->regenerateToken(); // セッション固定攻撃対策としてトークンを再生成
        return redirect('/login'); // ログアウト後、ログインページにリダイレクト
    }
}




