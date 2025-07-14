<?php

namespace Database\Seeders;

use App\Models\Schedule;
use App\Models\Weekday;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            WeekdaysSeeder::class,
            UserSeeder::class,
            LanguageSeeder::class,
            SchoolSeeder::class,
            // ClassroomSeeder::class,
            GradeSeeder::class,
            // StudentSeeder::class
        ]);
    }
}
