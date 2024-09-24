<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    // setUpメソッドを追加して、CSRFトークンを無効にする
    protected function setUp(): void
{
    parent::setUp();

    // CSRF トークンのチェックを無効化
    $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class);

    // すべてのミドルウェアを無効化
    $this->withoutMiddleware();
}

}
