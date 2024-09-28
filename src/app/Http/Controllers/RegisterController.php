<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member; // Memberモデルを使用
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use Illuminate\Auth\Events\Registered; // 追加
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    // 会員登録フォームの表示
    public function showRegistrationForm()
    {
        return view('register');
    }

    public function register(RegisterRequest $request)
    {
        //dd('RegisterRequest発動');
        // バリデーションは RegisterRequest により自動的に行われる
    
        // 新しいメンバーの作成
        $member = Member::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
    
        // 新しく登録したメンバーを自動的にログインさせる
        Auth::login($member);
    
        // メール確認リンクを送信
        event(new Registered($member));
    
        // メール確認ページではなく、トップページにリダイレクト
        return redirect('/'); // トップページにリダイレクト
    }


}
