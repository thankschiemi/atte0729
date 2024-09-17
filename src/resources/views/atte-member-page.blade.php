@extends('layouts.atte_layout')

@section('title', 'Atte - メンバー一覧')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/atte-member-page.css') }}" />
@endsection

@section('header-nav')
    <nav class="header-nav">
        <ul class="header-nav-list">
            <li class="header-nav-item"><a href="{{ url('/') }}">ホーム</a></li>
            <li class="header-nav-item"><a href="{{ url('/attendance') }}">日付一覧</a></li>
            <li class="header-nav-item"><a href="{{ url('/members') }}">メンバー一覧</a></li>
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
        <h1 class="member-list__title">メンバー一覧</h1>

        <!-- 検索フォーム -->
        <form class="member-list__search-form" action="{{ route('members.index') }}" method="GET">
            <input class="member-list__search-input" type="text" name="search" placeholder="名前またはメールアドレスで検索" value="{{ request('search') }}">
            <button class="member-list__search-button" type="submit">検索</button>
        </form>

        <!-- メンバー一覧テーブル -->
        <table class="member-list__table">
            <thead class="member-list__table-header">
                <tr>
                    <th class="member-list__table-header-cell">名前</th>
                    <th class="member-list__table-header-cell">メールアドレス</th>
                    <th class="member-list__table-header-cell">登録日</th>
                    <th class="member-list__table-header-cell">アクション</th>
                </tr>
            </thead>
            <tbody class="member-list__table-body">
                @foreach($members as $member)
                    <tr class="member-list__table-row">
                        <td class="member-list__table-cell">{{ $member->name }}</td>
                        <td class="member-list__table-cell">{{ $member->email }}</td>
                        <td class="member-list__table-cell">{{ $member->created_at->format('Y-m-d') }}</td>
                        <td class="member-list__table-cell">
                            <a class="member-list__action-link" href="{{ route('members.show', $member->id) }}">詳細</a>
                            <a class="member-list__action-link" href="{{ route('members.edit', $member->id) }}">編集</a>
                            <form class="member-list__delete-form" action="{{ route('members.destroy', $member->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="member-list__delete-button" type="submit" onclick="return confirm('本当に削除しますか？')">削除</button>
                            </form>
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
