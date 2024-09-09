<!-- resources/views/stamp.blade.php -->
@extends('layouts.atte_layout')

@section('title', 'Atte - 打刻ページ')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/stamp.css') }}" />
@endsection

@section('header-nav')
    <nav class="header-nav">
        <ul class="header-nav-list">
            <li class="header-nav-item"><a href="{{ url('/') }}">ホーム</a></li>
            <li class="header-nav-item"><a href="{{ url('/attendance') }}">日付一覧</a></li>
            <li class="header-nav-item">
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-button">ログアウト</button>
                </form>
            </li>
        </ul>
    </nav>
@endsection

@section('content')
    <div class="atte-form__content">
        <div class="atte-form__heading">
            <h1>{{ Auth::user()->name }}さんお疲れ様です！</h1>
        </div>
        <div class="form__button">
            <form action="{{ route('attendance.startWork') }}" method="POST">
                @csrf
                <button type="submit" class="form__button-submit {{ $buttonsEnabled['startWork'] ? '' : 'disabled' }}">
                    勤務開始
                </button>
            </form>
            <form action="{{ route('attendance.endWork') }}" method="POST">
                @csrf
                <button type="submit" class="form__button-submit {{ $buttonsEnabled['endWork'] ? '' : 'disabled' }}">
                    勤務終了
                </button>
            </form>
            <form action="{{ route('attendance.startBreak') }}" method="POST">
                @csrf
                <button type="submit" class="form__button-submit {{ $buttonsEnabled['startBreak'] ? '' : 'disabled' }}">
                    休憩開始
                </button>
            </form>
            <form action="{{ route('attendance.endBreak') }}" method="POST">
                @csrf
                <button type="submit" class="form__button-submit {{ $buttonsEnabled['endBreak'] ? '' : 'disabled' }}">
                    休憩終了
                </button>
            </form>
        </div>
    </div>
@endsection

