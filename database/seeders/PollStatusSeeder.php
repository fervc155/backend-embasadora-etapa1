<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PollStatus;
class PollStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PollStatus::create(['name'=>'En observacion']);
        PollStatus::create(['name'=>'Cliente curioso']);
        PollStatus::create(['name'=>'Cliente potencial']);
    }
}
