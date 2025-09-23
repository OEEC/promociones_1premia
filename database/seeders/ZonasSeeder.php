<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ZonasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('zonas')->insert([
            'nombre' => 'LAGUNA',
            'estatus' => 1,
        ]);

        DB::table('zonas')->insert([
            'nombre' => 'DURANGO',
            'estatus' => 1,
        ]);

        DB::table('zonas')->insert([
            'nombre' => 'NORTE',
            'estatus' => 1,
        ]);

        DB::table('zonas')->insert([
            'nombre' => 'CDMX',
            'estatus' => 1,
        ]);

        DB::table('zonas')->insert([
            'nombre' => 'SUR',
            'estatus' => 1,
        ]);
    }
}
