@extends('layouts.app')

@section('title', 'メンバー編集')

@section('content')
<div class="member-edit">
    <h1 class="member-edit__title">{{ $member->name }}さんの情報を編集</h1>
    
    <form action="{{ route('members.update', $member->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">名前</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $member->name) }}" required>
        </div>

        <div class="form-group">
            <label for="email">メールアドレス</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $member->email) }}" required>
        </div>

        <div class="form-group">
            <label for="employee_id">社員ID</label>
            <input type="text" name="employee_id" id="employee_id" class="form-control" value="{{ old('employee_id', $member->employee_id) }}" required>
        </div>

        <button type="submit" class="btn btn-success">更新</button>
    </form>

    <a href="{{ route('members.index') }}" class="btn btn-secondary">一覧に戻る</a>
</div>
@endsection
