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

    // ユーザーが存在するか確認
    $user = \App\Models\Member::where('email', $credentials['email'])->first();

    if (!$user) {
        // ユーザーが見つからない場合
        return redirect()->back()->withErrors(['email' => 'ユーザーが見つかりません']);
    }

    // パスワードが一致しない場合
    if (!\Hash::check($credentials['password'], $user->password)) {
        return redirect()->back()->withErrors(['password' => 'パスワードが正しくありません']);
    }

    // ログイン成功
    if (Auth::attempt($credentials)) {
        return redirect()->intended('/');
    } else {
        return redirect()->back()->withErrors(['email' => 'ログインに失敗しました']);
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