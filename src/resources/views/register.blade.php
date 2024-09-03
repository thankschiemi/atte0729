<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Atte</title>
    <link rel="stylesheet" href="css/sanitize.css" />
    <link rel="stylesheet" href="css/register.css" />
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
                <h2>会員登録</h2>
            </div>
            <form class="form" action="{{ url('/register') }}" method="post">
                @csrf
                <div class="form__group">
                    <div class="form__input--text">
                        <input type="text" name="name" placeholder="名前" autocomplete="name" required />
                    </div>
                </div>
                <div class="form__group">
                    <div class="form__input--text">
                        <input type="email" name="email" placeholder="メールアドレス" autocomplete="email" required />
                    </div>
                </div>
                <div class="form__group">
                    <div class="form__input--text">
                        <input type="password" name="password" placeholder="パスワード" autocomplete="new-password" required />
                    </div>
                </div>
                <div class="form__group">
                    <div class="form__input--text">
                        <input type="password" name="password_confirmation" placeholder="確認用パスワード" autocomplete="new-password" required />
                    </div>
                </div>
                <div class="form__button">
                    <button class="form__button-submit">会員登録</button>
                </div>
                <div class="form__nav">
                    <p class="form__nav-text">アカウントをお持ちでない方はこちらから</p>
                </div>
                <div class="form__cta">
                    <a href="/login" class="form__cta-text">ログイン</a>
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