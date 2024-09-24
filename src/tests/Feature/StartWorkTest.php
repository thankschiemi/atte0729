<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Member;
use App\Models\Date;
use Carbon\Carbon;

class StartWorkTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_start_work()
{
    // 認証されたユーザーを作成
    $member = Member::factory()->create();

    // セッションを開始
    session()->start();

    // CSRFトークンをセッションから取得
    $csrfToken = session()->token();

    // ログインした状態でPOSTリクエストを送信
    $response = $this->actingAs($member)->post('/start-work', [
        '_token' => $csrfToken,  // セッションから取得したCSRFトークン
    ]);

    // ステータスコードが302（リダイレクト）であることを確認
    $response->assertStatus(302);

    // データベースに勤務開始のレコードが追加されたことを確認
    $this->assertDatabaseHas('dates', [
        'member_id' => $member->id,
        'date' => Carbon::today()->toDateString(),
    ]);
}
}




