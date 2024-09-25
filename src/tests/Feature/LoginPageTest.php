<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Member; // Member モデルを使う
use Illuminate\Support\Facades\Log;

class LoginPageTest extends TestCase
{
    use RefreshDatabase; // データベースをリフレッシュしてクリーンな状態でテストを実行

    public function test_login_page_is_accessible()
    {
        $response = $this->get('/login');
        $response->assertStatus(200); // ログインページが正しく表示されるか
    }

    public function test_user_can_login_with_valid_credentials()
    {
        $password = 'password123';
        $hashedPassword = bcrypt($password);
        
        // ログにパスワードとハッシュ化パスワードを出力
        Log::info('パスワード確認', ['raw' => $password, 'hashed' => $hashedPassword]);
        
        $member = \App\Models\Member::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);
        
        // ログイン試行
        $response = $this->post('/login', [
            'email' => $member->email,
            'password' => $password, // bcrypt化していないプレーンパスワード
        ]);
        
        $response->assertRedirect('/');
    }    



    public function test_user_can_logout()
    {
        // ログインしているメンバーを作成
        $member = Member::factory()->create();

        // ログイン
        $this->actingAs($member);

        // ログアウト試行
        $response = $this->post('/logout');

        // ログアウト後の挙動を確認
        $response->assertRedirect('/login'); // ログアウト後のリダイレクト先
        $this->assertGuest(); // ログアウトされたか確認
    }
}

