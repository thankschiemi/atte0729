<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    // setUpメソッドを追加して、CSRFトークンのチェックのみを無効にする
    protected function setUp(): void
    {
        parent::setUp();

        // ファサードのインスタンスをクリアして再初期化
        \Illuminate\Support\Facades\Facade::clearResolvedInstances();

        // CSRFトークンのチェックを無効にする（必要に応じて）
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class);
    }
}


