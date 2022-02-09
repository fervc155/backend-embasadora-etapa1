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
             'name'=>'fernando villanueva',
            'email'=>'fervillanueva.1998@yahoo.com',
            'password' => bcrypt('12345678'),
        ]);
        $user = User::where('email','fervillanueva.1998@yahoo.com')->first();
        $user->assignRole('senior');

    }
}
