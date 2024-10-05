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
    $member = Member::factory()->create(['email_verified_at' => now()]); // メール認証済みのメンバーを作成
    $response = $this->actingAs($member)->get('/timesheets'); // リダイレクトを確認
    $response->assertRedirect(); // リダイレクトを確認

    // リダイレクト先のURLを取得
    $redirectUrl = $response->getTargetUrl();
    $response = $this->get($redirectUrl); // リダイレクト先にアクセス

    $response->assertStatus(200);
    $response->assertViewIs('atte-attendance-page'); // ビュー名を修正
}


        
}
