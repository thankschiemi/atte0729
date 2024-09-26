<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Member; // Memberモデルをインポート

class MemberControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_members()
    {
        // 認証済みメンバーを作成して認証
        $member = Member::factory()->create([
            'email' => 'testmember@example.com',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(), // メール確認済み
        ]);
    
        $this->actingAs($member); // メンバーを認証状態にする
    
        // 別のメンバーを作成
        $otherMember = Member::factory()->create([
            'name' => '山田太郎',
            'email' => 'yamada@example.com',
            'password' => bcrypt('password123'),
            'employee_id' => 'EMP-001',
        ]);
    
        // メンバー一覧を取得するリクエストを送信
        $response = $this->getJson('/members');
    
        // レスポンスの検証
        $response->assertStatus(200); // ステータスコード200を確認
        $response->assertJsonFragment(['name' => '山田太郎']); // メンバーがレスポンスに含まれていることを確認
    }
    
}
