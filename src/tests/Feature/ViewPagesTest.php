<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Member;

class ViewPagesTest extends TestCase
{
    public function test_stamp_page_is_accessible()
    {
        // ダミーのユーザーを作成
        $member = Member::factory()->create(['email_verified_at' => now()]); // メール認証を済ませたユーザーを作成

        // 認証されたユーザーとしてリクエストを行う
        $response = $this->actingAs($member)->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('stamp'); // 'stamp' ビューが返されることを確認
    }

    public function test_register_page_is_accessible()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response->assertViewIs('register'); // 会員登録ページのビュー名が 'register' である場合
    }

    public function test_login_page_is_accessible()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertViewIs('login'); // ログインページのビュー名が 'login' である場合
    }

    public function test_attendance_page_is_accessible()
    {
        $member = Member::factory()->create(['email_verified_at' => now()]); // メール認証済みのメンバーを作成
        $response = $this->actingAs($member)->get('/attendance'); // attendanceページにアクセス
        $response->assertStatus(200);
        $response->assertViewIs('attendance'); // ビュー名が正しいことを確認
    }
    
    public function test_members_page_is_accessible()
    {
        $member = Member::factory()->create(['email_verified_at' => now()]); // メール認証済みのメンバーを作成
        $response = $this->actingAs($member)->get('/members'); // membersページにアクセス
        $response->assertStatus(200);
        $response->assertViewIs('members.atte-member-page'); // ビュー名が正しいことを確認
    }
    
    public function test_timesheets_page_is_accessible()
{
    // メール認証済みのユーザーを作成
    $member = Member::factory()->create(['email_verified_at' => now()]); 

    // 認証されたユーザーとしてリクエストを送信し、リダイレクトを確認
    $response = $this->actingAs($member)->get('/timesheets');

    // リダイレクトのステータスを確認
    $response->assertStatus(302); // リダイレクトのステータスが302であることを確認
    $response->assertRedirect(); // リダイレクトが発生することを確認

    // リダイレクト先のURLを取得
    $redirectUrl = $response->getTargetUrl();
    
    // リダイレクト先にアクセスしてステータスとビュー名を確認
    $response = $this->actingAs($member)->get($redirectUrl); // 認証状態を再度確認しながらアクセス
    $response->assertStatus(200); // ステータスコードが200であることを確認
    $response->assertViewIs('atte-attendance-page'); // ビュー名が正しいことを確認
}

}
