@extends('layouts.app')

@section('title', 'メンバー詳細')

@section('content')
<div class="member-show">
    <h1 class="member-show__title">{{ $member->name }}さんの詳細情報</h1>
    
    <div class="member-show__details">
        <p><strong>名前:</strong> {{ $member->name }}</p>
        <p><strong>メールアドレス:</strong> {{ $member->email }}</p>
        <p><strong>社員ID:</strong> {{ $member->employee_id }}</p>
        <p><strong>登録日:</strong> {{ $member->created_at->format('Y-m-d') }}</p>
    </div>

    <div class="member-show__actions">
        <a href="{{ route('members.edit', $member->id) }}" class="btn btn-primary">編集</a>
        <form action="{{ route('members.destroy', $member->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('本当に削除しますか？')">削除</button>
        </form>
    </div>

    <a href="{{ route('members.index') }}" class="btn btn-secondary">一覧に戻る</a>
</div>
@endsection
