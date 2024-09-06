<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Atte - 打刻ページ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/stamp.css') }}" />
</head>

<body>
    <header class="header">
        <h1 class="header-ttl">
            <a class="header__logo" href="/">
                Atte
            </a>
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

    <main>
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
