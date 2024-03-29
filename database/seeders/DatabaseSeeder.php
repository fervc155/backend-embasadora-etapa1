<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Database\Seeders\{RoleSeeder, PollsSeeder,PollStatusSeeder,UserSeeder};

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            PollStatusSeeder::class,
            QuoteStatusSeeder::class,
            PollsSeeder::class,
            UserSeeder::class,
        ]);
    }
}
