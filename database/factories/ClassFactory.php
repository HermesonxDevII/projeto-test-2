<?php

namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;
use App\Models\{ Role };

class ClassFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'link' => $this->faker->paragraph(1),
            'start' => Carbon::createFromTimeStamp($this->faker->time()),
            'end' => function (array $attributes) {
                return $attributes['start']->addHours($this->faker->numberBetween(1, 8));
            },
            'teacher_id' => function() {
                return $this->faker->randomElement(Role::find(2)->users->pluck('id'));
            }
        ];
    }
}
