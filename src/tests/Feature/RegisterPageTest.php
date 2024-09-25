<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Member;

class RegisterPageTest extends TestCase
{

    use RefreshDatabase; // テストごとにデータベースをリセット

    public function test_register_page_is_accessible()
    {
        $response = $this->get('/register');
        $response->assertStatus(200); // ページが正しく表示されるか確認
        $response->assertViewIs('register'); // 表示されるViewが登録フォームかどうか
    }
    public function test_member_can_register()
    {
        // 新しいMemberのデータをシミュレーション
        $memberData = [
            'name' => 'テストメンバー',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123', // パスワード確認
        ];

        // 登録処理を実行
        $response = $this->post('/register', $memberData);

        // 成功時のリダイレクトを確認
        $response->assertRedirect('/'); // 登録後に / にリダイレクトされることを確認

        // データベースにMemberが存在することを確認
        $this->assertDatabaseHas('members', [
            'email' => 'test@example.com',
        ]);
    }
}
