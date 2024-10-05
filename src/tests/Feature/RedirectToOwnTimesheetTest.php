<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Member;
use Carbon\Carbon;  // Carbonクラスをインポート

class RedirectToOwnTimesheetTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_is_redirected_to_own_timesheet()
    {
        // ログインユーザーを作成
        $user = Member::factory()->create();

        // ログイン状態にする
        $this->actingAs($user);

        // リダイレクトリクエストを実行
        $response = $this->get('/timesheets');

        // 現在の年月を取得
        $yearMonth = Carbon::now()->format('Y-m');

        // 正しいリダイレクト先を確認
        $response->assertRedirect(route('attendance.timesheet', ['userId' => $user->id, 'yearMonth' => $yearMonth]));
    }
}


