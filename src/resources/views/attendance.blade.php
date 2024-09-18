@extends('layouts.atte_layout')

@section('title', 'Atte - 勤務時間一覧')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/attendance.css') }}" />
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
    <div class="date-list">
        <div class="date-list__navigation">
            <a href="{{ route('attendance.date', ['date' => $prevDate]) }}" class="date-list__nav-button"><</a>
            <span class="date-list__date">{{ $currentDate }}</span>
            <a href="{{ route('attendance.date', ['date' => $nextDate]) }}" class="date-list__nav-button">></a>
        </div>
    </div>

    <table class="schedule-table">
        <thead>
            <tr class="schedule-table__header-row">
                <th class="schedule-table__header">名前</th>
                <th class="schedule-table__header">勤務開始</th>
                <th class="schedule-table__header">勤務終了</th>
                <th class="schedule-table__header">休憩時間</th>
                <th class="schedule-table__header">勤務時間</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $employee)
            <tr class="schedule-table__row">
                <td class="schedule-table__cell">{{ $employee->member->name }}</td>
                <td class="schedule-table__cell">{{ $employee->start_work }}</td>
                <td class="schedule-table__cell">{{ $employee->end_work }}</td>

                {{-- 休憩時間の表示 --}}
                <td class="schedule-table__cell">
                    @php
                        $totalBreakTime = 0; // 初期化
                        foreach ($employee->breaks as $break) {
                            if ($break->start_break && $break->end_break) {
                                // 休憩時間を計算
                                $totalBreakTime += \Carbon\Carbon::parse($break->end_break)
                                    ->diffInSeconds(\Carbon\Carbon::parse($break->start_break));
                            }
                        }
                    @endphp

                    {{-- 休憩時間を表示 --}}
                    {{ gmdate('H:i:s', $totalBreakTime) }}
                </td>

                {{-- 勤務時間の表示（休憩時間を差し引いた勤務時間） --}}
                <td class="schedule-table__cell">
                    @php
                        // 勤務時間を計算
                        $workDuration = \Carbon\Carbon::parse($employee->end_work)
                            ->diffInSeconds(\Carbon\Carbon::parse($employee->start_work));

                        // 勤務時間から休憩時間を差し引く
                        $netWorkDuration = $workDuration - $totalBreakTime;
                    @endphp
                    {{ gmdate('H:i:s', $netWorkDuration) }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="pagination">
        {{ $employees->links('vendor.pagination.custom') }}
    </div>
@endsection
