<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{
    Student,
    Classroom
};

class StudentSeeder extends Seeder
{
    public function run()
    {
        $students = Student::factory(10)->create();

        foreach ($students as $student) {
            $student->classrooms()->attach(
                Classroom::select('id')->inRandomOrder()->get()->take(3)
            );
        }
    }
}