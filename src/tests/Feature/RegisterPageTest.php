<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterPageTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_register_page_is_accessible()
    {
        $response = $this->get('/register');
        $response->assertStatus(200); // ページが正しく表示されるか確認
        $response->assertViewIs('register'); // 表示されるViewが登録フォームかどうか
    }
    
}
