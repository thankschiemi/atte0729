<?php

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Faker\Generator as Faker;
use Faker\Factory as FakerFactory;

class MemberFactory extends Factory
{
    protected $model = Member::class;

    public function definition()
    {
        $faker = FakerFactory::create('ja_JP');
        return [
            'name' => $faker->name, // Fakerの'name'フォーマットを使用
        ];
    }
}








