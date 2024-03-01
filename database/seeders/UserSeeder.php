<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = User::create([
             'name'=>'fernando senior',
            'email'=>'fer@senior.com',
            'password' => bcrypt('12345678'),
        ]);
        $user= User::whereEmail('fer@senior.com')->first();
        $user->assignRole('senior');

        $user = User::create([
             'name'=>'fernando clouser',
            'email'=>'fer@clouser.com',
            'password' => bcrypt('12345678'),
        ]);
        $user= User::whereEmail('fer@clouser.com')->first();
        $user->assignRole('clouser');


        $user = User::create([
             'name'=>'fernando hostess',
            'email'=>'fer@hostess.com',
            'user_id'=>2,
            'password' => bcrypt('12345678'),
        ]);
        $user= User::whereEmail('fer@hostess.com')->first();
        $user->assignRole('hostess');

    }
}
