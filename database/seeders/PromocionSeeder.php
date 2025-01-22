<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PromocionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('promociones')->insert([
            'nombre' => 1,
            'imagen' => '',
            'fecha_vigencia' => Carbon::parse('2025-02-01'),
            'created_at' =>  Carbon::now(),
            'estatus' => 1
        ]);
    }
}
