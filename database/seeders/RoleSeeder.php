<?php

namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run()
    {
        DB::table('roles')->insert([
            0 => [
                'id' => 1,
                'name' => 'admin',
                'description' => 'Administrador'
            ],
            1 => [
                'id' => 2,
                'name' => 'teacher',
                'description' => 'Professor'
            ],
            2 => [
                'id' => 3,
                'name' => 'guardian',
                'description' => 'Responsável'
            ]
        ]);
    }
}
