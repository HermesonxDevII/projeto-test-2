<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LanguageSeeder extends Seeder
{
    public function run()
    {
        DB::table('languages')->insert([
            0 => [
                'id' => 1,
                'name' => 'Português',
                'short_name' => 'pt_BR',
                'original_name' => 'Português',
                'deleted_at' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => null
            ],
            1 => [
                'id' => 2,
                'name' => 'Inglês',
                'short_name' => 'en',
                'original_name' => 'English',
                'deleted_at' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => null
            ],
            2 => [
                'id' => 3,
                'name' => 'Japonês',
                'short_name' => 'jp',
                'original_name' => '日本語',
                'deleted_at' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => null
            ],
            3 => [
                'id' => 4,
                'name' => 'Espanhol',
                'short_name' => 'es',
                'original_name' => 'Espanhol',
                'deleted_at' => null,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => null
            ],
        ]);
    }
}
