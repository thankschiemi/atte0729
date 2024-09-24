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
        // テスト用ユーザーを作成
        $member = Member::factory()->create();

        // 認証済みの状態で/attendanceにアクセスし、ステータスコード200を期待する
        $response = $this->actingAs($member)->get('/attendance');

        // 正しいビューが返されるか確認
        $response->assertStatus(200);
        $response->assertViewIs('attendance'); // ビューの名前に合わせて修正
    }
}

