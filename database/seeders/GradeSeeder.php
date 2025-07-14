<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GradeSeeder extends Seeder
{
    public function run()
    {
        DB::table('grades')->insert([
            0 => [
                'id' => 1,
                'name' => 'Shougakko 4',
                'short_name' => 'Shoug 4',
                'created_at' => Carbon::now()->toDateTimeString()
            ],
            1 => [
                'id' => 2,
                'name' => 'Shougakko 5',
                'short_name' => 'Shoug 5',
                'created_at' => Carbon::now()->toDateTimeString()
            ],
            2 => [
                'id' => 3,
                'name' => 'Shougakko 6',
                'short_name' => 'Shoug 6',
                'created_at' => Carbon::now()->toDateTimeString()
            ],
            3 => [
                'id' => 4,
                'name' => 'Chugakko 1',
                'short_name' => 'Chug 1',
                'created_at' => Carbon::now()->toDateTimeString()
            ],
            4 => [
                'id' => 5,
                'name' => 'Chugakko 2',
                'short_name' => 'Chug 2',
                'created_at' => Carbon::now()->toDateTimeString()
            ],
            5 => [
                'id' => 6,
                'name' => 'Chugakko 3',
                'short_name' => 'Chug 3',
                'created_at' => Carbon::now()->toDateTimeString()
            ],
            6 => [
                'id' => 7,
                'name' => 'Shougakko 1',
                'short_name' => 'Shoug 1',
                'created_at' => Carbon::now()->toDateTimeString()
            ],
            7 => [
                'id' => 8,
                'name' => 'Shougakko 2',
                'short_name' => 'Shoug 2',
                'created_at' => Carbon::now()->toDateTimeString()
            ],
            8 => [
                'id' => 9,
                'name' => 'Shougakko 3',
                'short_name' => 'Shoug 3',
                'created_at' => Carbon::now()->toDateTimeString()
            ],
        ]);
    }
}
