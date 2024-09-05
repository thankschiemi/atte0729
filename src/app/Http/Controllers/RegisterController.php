<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member; // Memberモデルを使用
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{
    // 会員登録フォームの表示
    public function showRegistrationForm()
    {
        return view('register');
    }

    // 会員登録処理の実行
    public function register(RegisterRequest $request)
    {
        // バリデーションは RegisterRequest により自動的に行われる

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
