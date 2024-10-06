<?php

namespace Tests\Feature;

use App\Models\Member;
use App\Models\WorkDate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Tests\TestCase;

class EndWorkTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_end_work()
    {
        // ユーザーを作成し、認証状態にする
        $member = Member::factory()->create([
            'email_verified_at' => now(),
        ]);

        // 作成したユーザーとしてログイン
        $this->actingAs($member);

        // 今日の日付
        $today = Carbon::today()->toDateString();

        // 勤務開始のデータを事前に作成
        WorkDate::create([
            'member_id' => $member->id,
            'date' => $today,
            'start_work' => Carbon::now(),
        ]);

        // 勤務終了をPOSTリクエストで送信
        $response = $this->post('/end-work', [
            '_token' => csrf_token(),
        ]);

        // リダイレクトのステータスを確認
        $response->assertStatus(302);

        // 'end_work'カラムが正しくデータベースに登録されているか確認
        $this->assertDatabaseHas('dates', [
            'member_id' => $member->id,
            'end_work' => Carbon::now(),  // 実際のロジックに応じて調整が必要
        ]);
    }
}


