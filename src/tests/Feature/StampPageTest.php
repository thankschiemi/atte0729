<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Member; // Member モデルを使用

class StampPageTest extends TestCase
{
    use RefreshDatabase; // テストが実行されるたびにデータベースをリセット

    /**
     * 認証されたユーザーが打刻ページにアクセスできるかテスト
     *
     * @return void
     */
    public function test_authenticated_user_can_access_stamp_page()
    {
        // 認証済みのテストユーザーを作成
        $member = Member::factory()->create([
        'email_verified_at' => now(), // メール認証済みとする
    ]);

        $this->actingAs($member) // 作成したユーザーで認証
            ->get('/') // 打刻ページにアクセス
            ->assertStatus(200); // ステータスコード200が返されることを確認
    }
}


