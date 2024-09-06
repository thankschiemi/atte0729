<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Atte - ログイン</title>
    <link rel="stylesheet" href="css/sanitize.css" />
    <link rel="stylesheet" href="css/login.css" />
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <a class="header__logo" href="/">
                Atte
            </a>
        </div>
    </header>

    <main>
        <div class="atte-form__content">
            <div class="atte-form__heading">
                <h2>ログイン</h2>
            </div>
            <form class="form" action="/login" method="post">
                @csrf
                <div class="form__group">
                    <div class="form__input--text">
                        <input type="email" name="email" placeholder="メールアドレス" value="{{ $contact['email'] ?? '' }}"/>
                        @error('email')
                        <div class="form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form__group">
                    <div class="form__input--text">
                        <input type="password" name="password" placeholder="パスワード" value="{{ $contact['password'] ?? '' }}"/>
                        @error('password')
                        <div class="form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form__button">
                    <button class="form__button-submit">ログイン</button>
                </div>
                <div class="form__nav">
                    <p class="form__nav-text">アカウントをお持ちでない方はこちらから</p>
                </div>
                <div class="form__cta">
                    <a href="{{ route('register') }}" class="form__cta-text">会員登録</a>
                </div>
            </form>
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