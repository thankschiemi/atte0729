@extends('layouts.atte_layout')

@section('title', 'Atte - ユーザー一覧')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/atte-member-page.css') }}" />
@endsection

@section('header-nav')
    <nav class="header-nav">
        <ul class="header-nav-list">
            <li class="header-nav-item"><a href="{{ url('/') }}">ホーム</a></li>
            <li class="header-nav-item"><a href="{{ url('/attendance') }}">日付一覧</a></li>
            <li class="header-nav-item"><a href="{{ url('/members') }}">ユーザー一覧</a></li>
            <li class="header-nav-item"><a href="{{ url('/timesheets') }}">勤怠表</a></li>
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
    <div class="member-list">
        <h2 class="member-list__title">ユーザー一覧</h2>

    <div class="search-container">
          <!-- 検索フォーム1 -->
        <form class="user-list__search-form" action="{{ route('members.index') }}" method="GET">
           <input class="user-list__search-input" type="text" name="employee_id" placeholder="社員IDで検索" value="{{ request('employee_id') }}">
           <button class="user-list__search-button" type="submit">検索</button>
        </form>
          <!-- 検索フォーム2 -->
        <form class="user-list__search-form" action="{{ route('members.index') }}" method="GET">
           <input class="user-list__search-input" type="text" name="name" placeholder="名前で検索" value="{{ request('name') }}">
           <button class="user-list__search-button" type="submit">検索</button>
        </form>
    </div>
</div>

<!-- メンバー一覧テーブル -->
<table class="member-list__table">
    <thead>
        <tr class="member-list__table-header">
            <th class="member-list__table-header-cell">社員ID</th> <!-- 社員IDを追加 -->
            <th class="member-list__table-header-cell">名前</th> <!-- 名前列のヘッダー -->
        </tr>
    </thead>
    <tbody class="member-list__table-body">
        @foreach($members as $member)
            <tr class="member-list__table-row">
                <td class="member-list__table-cell">{{ $member->employee_id }}</td> <!-- 社員IDを追加 -->
                <td class="member-list__table-cell">
                    <!-- 名前をリンクにして勤怠表ページに遷移 -->
                    <a href="{{ route('timesheets', ['userId' => $member->id]) }}">{{ $member->name }}</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>


        <!-- ページネーションリンク -->
        <div class="member-list__pagination">
            {{ $members->links() }}
        </div>
    </div>
@endsection
