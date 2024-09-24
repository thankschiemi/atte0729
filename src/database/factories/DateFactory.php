<?php

namespace Database\Factories;

use App\Models\Date;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class DateFactory extends Factory
{
    protected $model = Date::class;

    public function definition()
    {
        return [
            'member_id' => 1, // 適切なIDを設定
            'date' => Carbon::today(),
            'start_work' => Carbon::now(),
            'end_work' => null,  // 勤務終了していない
        ];
    }
}

