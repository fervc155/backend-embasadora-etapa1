<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class QuoteStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('quote_statuses')->insert(['name'=>'Enviada por correo']);
        DB::table('quote_statuses')->insert(['name'=>'Primera llamada']);
        DB::table('quote_statuses')->insert(['name'=>'Segunda llamada']);
        DB::table('quote_statuses')->insert(['name'=>'Tercera llamada']);
        DB::table('quote_statuses')->insert(['name'=>'Cancelada']);
        DB::table('quote_statuses')->insert(['name'=>'Aprobada']);

    }
}
