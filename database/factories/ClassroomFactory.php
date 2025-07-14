<?php

namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\School;

class ClassroomFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'school_id' => $this->faker->randomElement(School::all()->pluck('id')),
            'description' => $this->faker->text(),
            'status' => $this->faker->randomElement([0, 1])
        ];
    }
}
