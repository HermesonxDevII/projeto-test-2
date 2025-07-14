<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\{ Role, Classroom, Weekday};

class ScheduleFactory extends Factory
{
    public function definition()
    {
        return [
            'weekday_id' => $this->faker->randomElement(Weekday::all()->pluck('id')),
            'status' => $this->faker->randomElement([0, 1])
        ];
    }
}