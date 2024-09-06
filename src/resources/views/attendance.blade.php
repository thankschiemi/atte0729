<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Atte - ログイン</title>
    <link rel="stylesheet" href="css/sanitize.css" />
    <link rel="stylesheet" href="css/attendance.css" />
</head>

<body>
    <header class="header">
        <h1 class="header__title">
            <a href="/" class="header__logo">
                Atte</a>
        </h1>
        <nav class="header-nav">
            <ul class="header-nav-list">
                <li class="header-nav-item"><a href="{{ url('/') }}">ホーム</a></li>
                <li class="header-nav-item"><a href="{{ url('/attendance') }}">日付一覧</a></li>
                <li class="header-nav-item">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        ログアウト
                    </a>
                </li>
            </ul>
        </nav>
    </header>

    <main class="main-content">
        <div class="date-list">
            <div class="date-list__navigation">
                <button class="date-list__nav-button">＜</button>
                <span class="date-list__date">2021-11-01</span>
                <button class="date-list__nav-button">＞</button>
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
                        <td class="schedule-table__cell">{{ $employee['member']['name'] }}</td>
                        <td class="schedule-table__cell">{{ $employee['start_work'] }}</td>
                        <td class="schedule-table__cell">{{ $employee['end_work'] }}</td>
                        <td class="schedule-table__cell">00:00:00</td> <!-- 休憩時間（仮の値） -->
                        <td class="schedule-table__cell">{{ \Carbon\Carbon::parse($employee['end_work'])->diff(\Carbon\Carbon::parse($employee['start_work']))->format('%H:%I:%S') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="pagination">
            {{ $employees->links('vendor.pagination.custom') }}
        </div>
    </main>
    <footer class="footer">
        <div class="footer__inner">
            <small class="footer__logo">
                Atte, inc.
            </small>
        </div>
    </footer>
</body>

</html>