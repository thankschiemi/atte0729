<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Member;

class MemberRequestTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        // 認証用のメンバーを作成し、メール確認済みとして扱う
        $this->actingAs(Member::factory()->create([
            'email_verified_at' => now(), // メール確認済みの状態をシミュレート
        ]), 'member');
    }

    // employee_idがnullableであり、かつ数値であることを確認するテスト
    public function test_employee_id_can_be_nullable_and_numeric()
    {
        $response = $this->json('GET', '/members', [
            'name' => '山田太郎',
        ]);

        $response->assertStatus(200); // 成功レスポンス
    }

    // employee_idに不正な値が入っている場合のテスト
    public function test_employee_id_must_be_numeric()
    {
        $response = $this->json('GET', '/members', [
            'employee_id' => 'ABC', // 数値ではない
        ]);

        $response->assertStatus(422); // バリデーションエラー
        $response->assertJsonValidationErrors('employee_id');
    }

    // 名前が正しい形式で検索されることのテスト
    public function test_name_must_be_valid_format()
    {
        $response = $this->json('GET', '/members', [
            'name' => '山田太郎',
        ]);

        $response->assertStatus(200); // 成功レスポンス
    }

    // 名前に数字や記号が含まれている場合のテスト
    public function test_name_cannot_contain_numbers_or_symbols()
    {
        $response = $this->json('GET', '/members', [
            'name' => '山田1234', // 数字が含まれている
        ]);

        $response->assertStatus(422); // バリデーションエラー
        $response->assertJsonValidationErrors('name');
    }
}
