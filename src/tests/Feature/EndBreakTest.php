<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Member;
use App\Models\Date;
use App\Models\Breakk;
use Carbon\Carbon;

class EndBreakTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_end_break()
{
    // 認証されたユーザーとしてテストを実行
    $this->actingAs(Member::factory()->create());

    // 事前に勤務データと休憩開始データを作成
    $date = Date::factory()->create([
        'member_id' => 1,
        'date' => Carbon::today(),
        'start_work' => Carbon::now(),
    ]);

    $breakk = Breakk::factory()->create([
        'date_id' => $date->id,
        'start_break' => Carbon::now()->subHour(),
    ]);

    // 休憩終了のPOSTリクエストを送信
    $response = $this->post('/end-break', [
        '_token' => csrf_token(),
    ]);

    // ステータスコード302を確認（リダイレクト）
    $response->assertStatus(302);

    // データベースに保存された最新の `breakk` を取得
    $updatedBreak = Breakk::where('date_id', $date->id)->first();

    // 休憩終了時間がnullではないことを確認
    $this->assertNotNull($updatedBreak->end_break);

    // データベースに休憩終了時間が正しく保存されているか確認
    $this->assertDatabaseHas('breakks', [
        'date_id' => $date->id,
        'end_break' => $updatedBreak->end_break->toDateTimeString(),
    ]);
}

}



