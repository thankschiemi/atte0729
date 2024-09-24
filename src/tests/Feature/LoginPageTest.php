<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginPageTest extends TestCase
{
    /**
     * テスト: ログインページに認証なしでアクセスできるか確認する
     */
    public function test_login_page_is_accessible()
{
    // ログインページへのアクセステスト
    $response = $this->get('/login');
    $response->assertStatus(200); // ステータスコードが200であることを確認
}

public function test_user_can_login_with_valid_credentials()
{
    // テスト用ユーザーの作成（パスワードをbcryptでハッシュ化）
    $user = \App\Models\Member::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password123'),  // ここでパスワードをハッシュ化
    ]);

    // ログインリクエストを送信
    $response = $this->post('/login', [
        'email' => 'test@example.com',
        'password' => 'password123',  // 平文のパスワード
    ]);

    // ログインが成功したかを確認
    $response->assertRedirect('/');
    $this->assertAuthenticatedAs($user);
}


public function test_user_can_logout()
{
    // テスト用ユーザーの作成とログイン
    $user = \App\Models\Member::factory()->create();
    $this->actingAs($user);

    // ログアウトリクエストの送信
    $response = $this->post('/logout');

    // 正しいリダイレクトを確認
    $response->assertRedirect('/login'); // ログアウト後にログインページにリダイレクトされると仮定
    $this->assertGuest(); // ログアウト後、認証されていないことを確認
}
}


