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
            'nombre' => 'OSCAR ENRIQUE',
            'apellido_paterno' => 'ESCOBAR',
            'apellido_materno' => 'DE LA CRUZ',
            'fecha_nacimiento' => Carbon::parse('1990-01-01'),
            'cp' => 27000,
            'created_at' =>  Carbon::now(),
        ]);

        DB::table('personas')->insert([
            'nombre' => 'OMAR',
            'apellido_paterno' => 'GOMEZ',
            'apellido_materno' => 'VAQUERA',
            'fecha_nacimiento' => Carbon::parse('1990-11-11'),
            'cp' => 27000,
            'created_at' =>  Carbon::now(),
        ]);
    }
}
