<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User; // 認証ユーザーのモデル
use App\Models\Member;

class MemberTest extends TestCase
{
    use RefreshDatabase;

    /**
     * メンバー一覧ページが正しくアクセスできるかテスト
     *
     * @return void
     */
    public function test_members_page_is_accessible()
    {
        $user = User::factory()->create(); // テスト用のユーザーを作成

        // actingAsでユーザーをログイン状態にしてアクセス
        $response = $this->actingAs($user)->get('/members');

        // ステータスコード200が返されることを確認
        $response->assertStatus(200);
    }

    /**
     * メンバーのデータが正しく表示されるかテスト
     *
     * @return void
     */
    public function test_members_are_displayed()
    {
        $user = User::factory()->create(); // テスト用のユーザーを作成

        // actingAsでログインさせてからメンバー2名を作成
        Member::factory()->create(['name' => '山田太郎', 'employee_id' => 'EMP-001']);
        Member::factory()->create(['name' => '田中花子', 'employee_id' => 'EMP-002']);

        // actingAsでメンバー一覧ページにアクセス
        $response = $this->actingAs($user)->get('/members');

        // ページに「山田太郎」と「田中花子」が表示されているかを確認
        $response->assertSee('山田太郎');
        $response->assertSee('田中花子');
    }
}


