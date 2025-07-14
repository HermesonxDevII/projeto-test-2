<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WeekdaysSeeder extends Seeder
{
    public function run()
    {
        DB::table('weekdays')->insert([
            0 => [
                'id' => 1,
                // 'name' => 'Monday',
                // 'short_name' => 'Mon',
                'name' => 'Segunda',
                'short_name' => 'Seg',
                'weekday_number' => 1,
                'created_at' => Carbon::now()
            ],
            1 => [
                'id' => 2,
                // 'name' => 'Tuesday',
                // 'short_name' => 'Tue',
                'name' => 'Terça',
                'short_name' => 'Ter',
                'weekday_number' => 2,
                'created_at' => Carbon::now()
            ],
            2 => [
                'id' => 3,
                // 'name' => 'Wednesday',
                // 'short_name' => 'Wed',
                'name' => 'Quarta',
                'short_name' => 'Qua',
                'weekday_number' => 3,
                'created_at' => Carbon::now()
            ],
            3 => [
                'id' => 4,
                // 'name' => 'Thursday',
                // 'short_name' => 'Thu',
                'name' => 'Quinta',
                'short_name' => 'Qui',
                'weekday_number' => 4,
                'created_at' => Carbon::now()
            ],
            4 => [
                'id' => 5,
                // 'name' => 'Friday',
                // 'short_name' => 'Fri',
                'name' => 'Sexta',
                'short_name' => 'Sex',
                'weekday_number' => 5,
                'created_at' => Carbon::now()
            ],
            5 => [
                'id' => 6,
                // 'name' => 'Saturday',
                // 'short_name' => 'Sat',
                'name' => 'Sábado',
                'short_name' => 'Sab',
                'weekday_number' => 6,
                'created_at' => Carbon::now()
            ],
            6 => [
                'id' => 7,
                // 'name' => 'Sunday',
                // 'short_name' => 'Sun',
                'name' => 'Domingo',
                'short_name' => 'Dom',
                'weekday_number' => 0,
                'created_at' => Carbon::now()
            ],
        ]);
    }
}