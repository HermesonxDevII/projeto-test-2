<?php

namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\{Role, Module};
use Carbon\Carbon;

class CourseFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'link' => $this->faker->word(1),
            'type' => $this->faker->randomElement([1, 2]),
            'start' => Carbon::createFromFormat('H:i:s', $this->faker->time()),
            'end' => function (array $attributes) {
                return Carbon::parse($attributes['start']
                    ->format('H:i:s'))
                    ->addHours($this->faker->numberBetween(1, 2));
            },
            'embed_code' => function (array $attributes) {
                return $attributes['type'] == 2
                    ? 'https://www.youtube.com/embed/AaeTcrOjyJ4'
                    : null;
            },
            'module_id' => function (array $attributes) {
                return $attributes['type'] == 2
                    ? $this->faker->randomElement(Module::all()->pluck('id'))
                    : null;
            },
            'teacher_id' => function() {
                return $this->faker->randomElement(
                    Role::find(2)->users->pluck('id')
                );
            }
        ];
    }
}
