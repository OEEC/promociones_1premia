<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PersonaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('personas')->insert([
            'nombre_completo' => 'OSCAR ENRIQUE ESCOBAR DE LA CRUZ',
            'fecha_nacimiento' => Carbon::parse('1990-01-01'),
            'cp' => 27000,
            'created_at' =>  Carbon::now(),
        ]);

    }
}
