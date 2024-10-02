@extends('layouts.atte_layout')

@section('title', 'Atte - 会員登録')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/register.css') }}" />
@endsection

@section('content')
    <div class="atte-form__content">
        <div class="atte-form__heading">
            <h2>会員登録</h2>
        </div>
        <form class="form" action="{{ url('/register') }}" method="post"novalidate>
            @csrf
            <div class="form__group">
                <div class="form__input--text">
                    <input type="text" name="name" placeholder="名前" value="{{ old('name') }}" required />
                    @error('name')
                    <div class="form__error">{{ $message }}</div>
                    @enderror
                </div>
            </div>
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
            <div class="form__group">
                <div class="form__input--text">
                    <input type="password" name="password_confirmation" placeholder="パスワード（確認用）" required />
                    @error('password_confirmation')
                    <div class="form__error">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form__button">
                <button class="form__button-submit">会員登録</button>
            </div>
            <div class="form__nav">
                <p class="form__nav-text">アカウントをお持ちでない方はこちらから</p>
            </div>
            <div class="form__cta">
                <a href="{{ route('login') }}" class="form__cta-text">ログイン</a>
            </div>
        </form>
    </div>
@endsection

