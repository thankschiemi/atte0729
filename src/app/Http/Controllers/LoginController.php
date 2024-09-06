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
        return view('login');
    }

    public function login(LoginRequest $request)
    {
        // バリデーションは RegisterRequest により自動的に行われる
        $credentials = $request->only('email', 'password');

        // ユーザーの存在を確認
        $user = \App\Models\Member::where('email', $credentials['email'])->first();

        if ($user) {
            // ユーザーが存在する場合、パスワードの一致を確認
            if (Hash::check($credentials['password'], $user->password)) {
                // パスワードが一致した場合、ログインを試みる
                if (Auth::attempt($credentials)) {
                    return redirect()->intended('/');
                }
            } else {
                // パスワードが一致しない場合
                dd('パスワードが一致しません');
            }
        } else {
            // ユーザーが存在しない場合
            dd('ユーザーが見つかりません');
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
