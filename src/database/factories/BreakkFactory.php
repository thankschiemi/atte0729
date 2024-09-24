<?php

namespace Database\Factories;

use App\Models\Breakk;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class BreakkFactory extends Factory
{
    protected $model = Breakk::class;

    public function definition()
    {
        return [
            'date_id' => 1, // テスト中に適切な値を設定するか、適宜変更します
            'start_break' => Carbon::now()->subHour(), // 1時間前の休憩開始
            'end_break' => null, // 休憩中
        ];
    }
}
