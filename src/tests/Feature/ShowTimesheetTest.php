<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Member;
use App\Models\WorkDate;  // WorkDateモデルをインポート
use Carbon\Carbon;

class ShowTimesheetTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_specific_user_timesheet()
    {
        // ユーザーの作成とログイン
        $user = Member::factory()->create();
        $this->actingAs($user);

        // 勤怠情報を作成
        WorkDate::factory()->create([
            'member_id' => $user->id,
            'date' => Carbon::today(),
        ]);

        // 指定したユーザーの勤怠表ページにアクセス
        $response = $this->get(route('attendance.timesheet', ['userId' => $user->id, 'yearMonth' => '2024-09']));

        // ビューが正しいか確認
        $response->assertViewIs('atte-attendance-page');

        // ビューに渡されている変数を確認
        $response->assertViewHas('timesheets');
        $response->assertViewHas('user');
        $response->assertViewHas('currentMonth');
    }
}


