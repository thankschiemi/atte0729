<!-- resources/views/layouts/atte_layout.blade.php -->
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css') <!-- 各ページのCSSをここに埋め込む -->
</head>

<body>
    <header class="header">
        <h1 class="header__title">
            <a href="/" class="header__logo">Atte</a>
        </h1>
        @yield('header-nav') <!-- ページ固有のナビゲーションをここに埋め込む -->
    </header>

    <main class="main-content">
        @yield('content') <!-- 各ページ固有のコンテンツ -->
    </main>

    <footer class="footer">
        <div class="footer__inner">
            <small class="footer__logo">Atte, inc.</small>
        </div>
    </footer>

</body>

</html>
