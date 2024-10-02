<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen()
{
    $password = 'password'; // ファクトリで設定されているパスワード
    $user = User::factory()->create(['password' => bcrypt($password)]); // bcryptでハッシュ化されたパスワードを設定

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => $password, // 確認するパスワードを使用
    ]);

    $this->assertAuthenticatedAs($user); // 認証が成功しているか確認
    $response->assertRedirect(RouteServiceProvider::HOME);
}


    public function test_users_can_not_authenticate_with_invalid_password()
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }
}
