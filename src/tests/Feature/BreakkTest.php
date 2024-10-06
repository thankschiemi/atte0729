<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Breakk; // Breakkモデルを使用
use App\Models\WorkDate;   // WorkDateモデルを使用
use App\Models\Member; // Memberモデルを使用

class BreakkTest extends TestCase
{
    use RefreshDatabase; // テスト実行時にデータベースをリフレッシュ

    /**
     * Breakkモデルのインスタンスが作成できるか確認するテスト
     */
    public function test_create_breakk_instance()
    {
        // Memberモデルのダミーデータを作成
        $member = Member::factory()->create();

        //WorkDateモデルのダミーデータを作成 (Memberと関連付け)
        $date = WorkDate::factory()->create([
            'member_id' => $member->id,  // MemberのIDを関連付け
        ]);

        // Breakkモデルのダミーデータを作成
        $breakk = Breakk::factory()->create([
            'date_id' => $date->id,  // DateのIDを使用
            'start_break' => now(),
            'end_break' => now()->addHours(1),
        ]);

        // データが正しく作成されたか確認
        $this->assertDatabaseHas('breakks', [
            'date_id' => $date->id,
            'start_break' => $breakk->start_break,
            'end_break' => $breakk->end_break,
        ]);
    }
}

