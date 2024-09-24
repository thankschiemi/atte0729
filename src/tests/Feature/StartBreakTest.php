<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Member;
use App\Models\Date;
use Illuminate\Support\Facades\Log;  // 追加
use Carbon\Carbon;

class StartBreakTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_start_break()
    {
        // Log::info('テスト開始: 休憩開始処理');
        
        // ユーザーのログイン状態を設定
        $this->actingAs(Member::factory()->create());

        // 事前に勤務データを作成
        $date = Date::factory()->create([
            'member_id' => 1,
            'date' => Carbon::today(),
            'start_work' => Carbon::now(),
        ]);

        // Log::info('勤務データが作成されました', ['date_id' => $date->id]);

        // 休憩開始のPOSTリクエストを送信
        $response = $this->post('/start-break', [
            '_token' => csrf_token(),
        ]);

        // Log::info('休憩開始のPOSTリクエストが送信されました');

        // ステータスコード302を確認（リダイレクト）
        $response->assertStatus(302);

        // データベースに休憩のレコードが挿入されたか確認
        $this->assertDatabaseHas('breakks', [
            'date_id' => $date->id,
            // start_breakがnullでないことを確認
            'start_break' => now(),
        ]);

        // Log::info('テスト終了: 休憩開始処理');
    }
}
