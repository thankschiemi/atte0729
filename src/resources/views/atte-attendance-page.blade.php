@extends('layouts.atte_layout')

@section('title', 'Atte - 勤怠表')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/atte-attendance-page.css') }}" />
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
<div class="atte-form__content">
    <div class="atte-form__heading">
        <h1>{{ $user->name }}さんの勤怠表</h1> <!-- 特定のユーザー名を表示 -->
    </div>

    <div class="date-list">
    　　<div class="date-list__navigation">
    　　　　<a href="{{ route('attendance.timesheet', ['userId' => $user->id, 'yearMonth' => $prevMonth]) }}" class="date-list__nav-button"><</a>
    　　　　<span class="date-list__date">{{ $currentMonth->format('Y-m') }}</span>
    　　　　<a href="{{ route('attendance.timesheet', ['userId' => $user->id, 'yearMonth' => $nextMonth]) }}" class="date-list__nav-button">></a>
　　　　</div>


    </div>

    <table class="schedule-table">
        <thead>
            <tr class="schedule-table__header-row">
                <th class="schedule-table__header">日付</th>
                <th class="schedule-table__header">勤務開始</th>
                <th class="schedule-table__header">勤務終了</th>
                <th class="schedule-table__header">休憩時間</th>
                <th class="schedule-table__header">勤務時間</th>
            </tr>
        </thead>
        <tbody class="timesheet-table__body">
    @foreach ($timesheets as $timesheet)
        <tr class="timesheet-table__row">
            <td class="timesheet-table__cell timesheet-table__cell--date">{{ $timesheet->date }}</td>
            <td class="timesheet-table__cell timesheet-table__cell--start">{{ \Carbon\Carbon::parse($timesheet->start_work)->format('H:i') }}</td>
            <td class="timesheet-table__cell timesheet-table__cell--end">{{ \Carbon\Carbon::parse($timesheet->end_work)->format('H:i') }}</td>

            {{-- 休憩時間 --}}
            <td class="timesheet-table__cell timesheet-table__cell--break">
                @php
                    $totalBreakTime = 0;
                    foreach ($timesheet->breaks as $break) {
                        if ($break->start_break && $break->end_break) {
                            $totalBreakTime += \Carbon\Carbon::parse($break->end_break)
                                ->diffInSeconds(\Carbon\Carbon::parse($break->start_break));
                        }
                    }
                @endphp
                {{ gmdate('H:i', $totalBreakTime) }}
            </td>

            {{-- 勤務時間 --}}
            <td class="timesheet-table__cell timesheet-table__cell--work-duration">
                @php
                    $workDuration = \Carbon\Carbon::parse($timesheet->end_work)
                        ->diffInSeconds(\Carbon\Carbon::parse($timesheet->start_work));
                    $netWorkDuration = $workDuration - $totalBreakTime;
                @endphp
                {{ gmdate('H:i', $netWorkDuration) }}
            </td>
        </tr>
    @endforeach
</tbody>

    </table>

    <div class="pagination">
        {{ $timesheets->links('vendor.pagination.custom') }}
    </div>
</div>
@endsection
