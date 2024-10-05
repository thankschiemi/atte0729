<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Member;

class MemberControllerTest extends TestCase
{
    use RefreshDatabase;

    // 認証されたメンバーがメンバー一覧ページを正しくレンダリングできるかのテスト
    public function test_can_render_members_page()
    {
        $member = Member::factory()->create([
            'email' => 'testmember@example.com',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(), // メール確認済み
        ]);

        $this->actingAs($member); // 認証状態にする

        // メンバー一覧ページにアクセス
        $response = $this->get('/members');

        // ステータスコード200を確認
        $response->assertStatus(200);

        // レンダリングされたページに「ユーザー一覧」という文字が含まれているかを確認
        $response->assertSee('ユーザー一覧');
    }

    // 検索機能のテスト（名前検索）
    public function test_can_search_members_by_name()
    {
        $member = Member::factory()->create([
            'email' => 'testmember@example.com',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(), // メール確認済み
        ]);

        $this->actingAs($member); // 認証状態にする

        // 検索対象のメンバーを作成
        $searchMember = Member::factory()->create([
            'name' => '山田太郎',
            'email' => 'yamada@example.com',
            'employee_id' => 'EMP-001',
        ]);

        // 名前で検索を行うリクエスト
        $response = $this->getJson('/members?name=山田');

        // ステータスコード200と、検索結果に正しいメンバー情報が含まれているかを確認
        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => '山田太郎']);
    }

    // 認証されていないユーザーがメンバー一覧にアクセスしようとするときのテスト
    public function test_cannot_access_members_without_authentication()
    {
        // 認証されていない状態でメンバー一覧を取得しようとする
        $response = $this->get('/members');

        // ステータスコード302（ログインページへのリダイレクト）を確認
        $response->assertStatus(302);
    }

    // ページネーションが正しく機能しているかを確認するテスト
    public function test_members_pagination()
{
    $member = Member::factory()->create([
        'email' => 'testmember@example.com',
        'password' => bcrypt('password123'),
        'email_verified_at' => now(), // メール確認済み
    ]);

    $this->actingAs($member); // 認証状態にする

    // 10人のメンバーを作成（1ページ5人、2ページ目にも5人が表示される）
    Member::factory(10)->create();

    // 1ページ目を取得（JSON形式でのリクエスト）
    $response = $this->getJson('/members');

    // ステータスコード200と、1ページ目に5人のメンバーが表示されることを確認
    $response->assertStatus(200);
    $this->assertCount(5, $response->json('data')); // ページネーション5名

    // 2ページ目を取得（JSON形式でのリクエスト）
    $response = $this->getJson('/members?page=2');

    // ステータスコード200と、2ページ目に5人のメンバーが表示されることを確認
    $response->assertStatus(200);
    $this->assertCount(5, $response->json('data')); // 2ページ目も5名
}


}
