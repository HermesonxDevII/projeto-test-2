<?php

namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;

class ModuleFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'position' => $this->faker->numberBetween(1, 10)
        ];
    }
}