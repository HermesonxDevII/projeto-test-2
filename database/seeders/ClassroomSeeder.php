<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\{Classroom, Schedule, Course, Module};

class ClassroomSeeder extends Seeder
{
    public function run()
    {
        Classroom::factory(15)
            ->has(Course::factory()->count(3)
                ->has(Schedule::factory()->count(1)))
            ->has(Module::factory()->count(3))
        ->create();
    }
}