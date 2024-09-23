<?php

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class MemberFactory extends Factory
{
    protected $model = Member::class;

    public function definition()
    {
        static $employeeId = 1;

        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'employee_id' => str_pad($employeeId++, 3, '0', STR_PAD_LEFT),
            'password' => bcrypt('password'), // ダミーのパスワード
            'email_verified_at' => now(),
        ];
    }
}

