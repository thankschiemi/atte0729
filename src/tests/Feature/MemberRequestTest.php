<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Member;


class MemberRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_employee_id_can_be_nullable_and_numeric()
{
    // POSTリクエストを送信
    $response = $this->json('POST', '/members', [
        'name' => '山田太郎',
        'email' => 'test@example.com',
        'password' => 'password123',
    ]);

    $response->assertStatus(201); // 成功レスポンス

    // データベースから保存されたメンバー情報を取得
    $member = Member::where('email', 'test@example.com')->first();

    // employee_idが自動生成されているか確認
    $this->assertNotNull($member->employee_id);
    $this->assertDatabaseHas('members', [
        'employee_id' => $member->employee_id,
        'name' => '山田太郎',
        'email' => 'test@example.com',
    ]);
}

}

