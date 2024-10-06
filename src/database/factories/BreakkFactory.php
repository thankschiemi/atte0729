<?php

namespace Database\Factories;

use App\Models\Breakk;
use App\Models\WorkDate;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;


class BreakkFactory extends Factory
{
    protected $model = Breakk::class;

    public function definition()
{
    return [
        'date_id' => Date::factory(),
        'start_break' => $this->faker->dateTimeBetween('-2 hours', 'now'),
        'end_break' => null,
    ];
}


}
