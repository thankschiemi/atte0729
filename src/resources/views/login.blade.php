@extends('layouts.atte_layout')

@section('title', 'Atte - ログイン')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}" />
@endsection

@section('content')
    <div class="atte-form__content">
        <div class="atte-form__heading">
            <h2>ログイン</h2>
        </div>
        <form class="form" action="/login" method="post">
            @csrf
            <div class="form__group">
                <div class="form__input--text">
                    <input type="email" name="email" placeholder="メールアドレス" value="{{ old('email') }}" required />
                    @error('email')
                    <div class="form__error">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form__group">
                <div class="form__input--text">
                    <input type="password" name="password" placeholder="パスワード" required />
                    @error('password')
                    <div class="form__error">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form__button">
                <button class="form__button-submit">ログイン</button>
            </div>
            <div class="form__nav">
                <p class="form__nav-text">アカウントをお持ちでない方はこちらから</p>
            </div>
            <div class="form__cta">
                <a href="{{ route('register') }}" class="form__cta-text">会員登録</a>
            </div>
        </form>
    </div>
@endsection

