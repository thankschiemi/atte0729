<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member; // Memberモデルを使用
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    // 会員登録フォームの表示
    public function showRegistrationForm()
    {
        return view('register');
    }

    // 会員登録処理の実行
    public function register(Request $request)
    {
        // バリデーション
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:members', // 'users' を 'members' に変更
            'password' => 'required|string|min:8|confirmed',
        ]);

        // 新しいメンバーの作成
        $member = Member::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // /login ページへリダイレクト
        return redirect()->route('login'); // ルート名を指定
    }
}
