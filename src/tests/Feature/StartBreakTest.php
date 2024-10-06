<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Member;
use App\Models\WorkDate;
use App\Models\Breakk; // Breakkモデルを追加
use Carbon\Carbon;
//use Illuminate\Support\Facades\Log; // Logクラスをインポート

class StartBreakTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_start_break()
{
    // ユーザーのログイン状態を設定
    $member = Member::factory()->create();
    $this->actingAs($member);

    // 事前に勤務データを作成
    $date = WorkDate::factory()->create([
        'member_id' => $member->id,
        'date' => Carbon::today()->toDateString(),
        'start_work' => Carbon::now(),
    ]);

    // 休憩開始のPOSTリクエストを送信
    $response = $this->post('/start-break');

    // ステータスコード302を確認（リダイレクト）
    $response->assertStatus(302);

    // テスト中の date_id を確認
    //dd($date->id);  // これでテスト中の date_id を確認します

    // データベースに休憩のレコードが挿入されたか確認
    $this->assertDatabaseHas('breakks', [
        'date_id' => $date->id,
    ]);
}


}

