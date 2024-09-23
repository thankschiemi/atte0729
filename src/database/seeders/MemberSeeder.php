<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Member;

class MemberSeeder extends Seeder
{
    public function run()
    {
        // 100人分のダミーデータを作成
        Member::factory()->count(100)->create();
    }
}

