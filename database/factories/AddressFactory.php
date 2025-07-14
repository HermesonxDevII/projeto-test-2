<?php

namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    public function definition()
    {
        return [
            'zip_code' => $this->faker->numerify('######'),
            'province' => $this->faker->word(),
            'city' => $this->faker->word(),
            'district' => $this->faker->word(),
            'complement' => $this->faker->word()
        ];
    }
}
