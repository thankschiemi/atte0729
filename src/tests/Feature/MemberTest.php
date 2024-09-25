<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Member;

class MemberTest extends TestCase
{
    use RefreshDatabase;

    public function test_member_can_be_created()
    {
        // メンバーの作成データ
        $memberData = [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
            'employee_id' => 'EMP-001'
        ];

        // メンバーを作成
        $member = Member::create($memberData);

        // データベースに正しく保存されているかを確認
        $this->assertDatabaseHas('members', [
            'email' => 'test@example.com'
        ]);
    }

    public function test_member_can_be_updated()
    {
        // メンバーの作成
        $member = Member::factory()->create();

        // メンバーの名前を更新
        $member->update(['name' => '更新されたユーザー名']);

        // データベースに更新が反映されているか確認
        $this->assertDatabaseHas('members', [
            'name' => '更新されたユーザー名'
        ]);
    }

    public function test_member_can_be_deleted()
    {
        // メンバーの作成
        $member = Member::factory()->create();

        // メンバーの削除
        $member->delete();

        // データベースから削除されているかを確認
        $this->assertDeleted($member);
    }

    public function test_member_has_dates_relation()
    {
        // メンバーを作成
        $member = Member::factory()->create();

        // リレーションとして紐付く日付データを作成
        $member->dates()->create([
            'date' => now(),
        ]);

        // リレーションが正しく動作しているか確認
        $this->assertCount(1, $member->dates);
    }
}



