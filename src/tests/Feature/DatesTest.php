<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\WorkDate; // WorkDateモデルを使用
use App\Models\Member; // 関連するMemberモデル

class DatesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 日付データが正しく作成できるかのテスト
     *
     * @return void
     */
    public function test_can_create_date()
    {
        // テスト用のMemberを作成
        $member = Member::factory()->create();

        // 日付データを作成
        $date = WorkDate::create([
            'date' => '2024-09-26',
            'member_id' => $member->id, // Memberとの関連
        ]);

        // データベースに作成した日付データが存在することを確認
        $this->assertDatabaseHas('dates', [
            'date' => '2024-09-26',
            'member_id' => $member->id,
        ]);
    }

    /**
     * 日付データが正しく取得できるかのテスト
     *
     * @return void
     */
    public function test_can_retrieve_date()
    {
        $member = Member::factory()->create();
        $date = WorkDate::create([
            'date' => '2024-09-26',
            'member_id' => $member->id,
        ]);

        // データベースから取得して確認
        $retrievedDate = Date::find($date->id);
        $this->assertEquals($retrievedDate->date, '2024-09-26');
    }

    /**
     * 日付データが正しく更新できるかのテスト
     *
     * @return void
     */
    public function test_can_update_date()
    {
        $member = Member::factory()->create();
        $date = WorkDate::create([
            'date' => '2024-09-26',
            'member_id' => $member->id,
        ]);

        // 日付データを更新
        $date->update(['date' => '2024-09-27']);

        // 更新されたことを確認
        $this->assertDatabaseHas('dates', [
            'date' => '2024-09-27',
        ]);
    }

    /**
     * 日付データが正しく削除できるかのテスト
     *
     * @return void
     */
    public function test_can_delete_date()
    {
        $member = Member::factory()->create();
        $date = WorkDate::create([
            'date' => '2024-09-26',
            'member_id' => $member->id,
        ]);

        // 日付データを削除
        $date->delete();

        // データベースに存在しないことを確認
        $this->assertDatabaseMissing('dates', [
            'id' => $date->id,
        ]);
    }
}
