<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Member;

class AttendancePageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 認証済みユーザーが/attendanceページにアクセスできるかをテスト
     *
     * @return void
     */
    public function test_authenticated_user_can_access_attendance_page()
{
    // 認証済みのテストユーザーを作成
    $member = Member::factory()->create([
        'email_verified_at' => now(), // メール認証済みとする
    ]);

    // 認証済みユーザーで /attendance にアクセス
    $response = $this->actingAs($member)->get('/attendance');

    // ステータスコード200が返されることを確認
    $response->assertStatus(200);

    // 正しいビューが返されるか確認
    $response->assertViewIs('attendance');
}

}

