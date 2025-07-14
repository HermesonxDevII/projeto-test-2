<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{User, Address, Role};
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::factory()->has(Address::factory(1))->create([
            'name' => 'SmartLead',
            'email' => 'contato@smartlead.com.br',
            'password' => Hash::make('meliseduc@tion')
        ])->roles()->attach(1);

        $users = User::factory(19)->has(Address::factory()->count(1))->create();

        foreach ($users as $user) {
            $user->roles()->attach(
                Role::select('id')->inRandomOrder()->limit(1)->get()
            );
        }
    }
}
