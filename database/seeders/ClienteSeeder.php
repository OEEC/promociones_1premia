<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('clientes')->insert([
            'persona_id' => 1,
            'no_tarjeta' => '9948774631314875',
            'puntos' => 5,
            'created_at' =>  Carbon::now(),
        ]);
    }
}
