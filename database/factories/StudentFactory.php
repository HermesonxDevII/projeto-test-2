<?php

namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\{Grade, Student, User, Language, School, Role };

class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition()
    {
        return [
            'full_name' => $this->faker->firstName(),
            'guardian_id' => $this->faker->randomElement(
                Role::find(3)->users->pluck('id')
            ),
            'email' => $this->faker->unique()->safeEmail(),
            'domain_language_id' => $this->faker->randomElement(
                Language::all()->pluck('id')
            ),
            'school_id' => $this->faker->randomElement(
                School::all()->pluck('id')
            ),
            'grade_id' => $this->faker->randomElement(
                Grade::all()->pluck('id')
            ),
            'avatar_id' => $this->faker->numberBetween(1, 6),
            'status' => $this->faker->randomElement([0, 1]),
            'notes' => $this->faker->text(150)
        ];
    }
}