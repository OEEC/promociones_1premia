<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Ramsey\Uuid\Type\Integer;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userId = DB::table('users')->insertGetId([
            'name' => 'admin',
            'email' => 'innovacion3@gasamigas.com',
            'password' => Hash::make('123456789'),
            'created_at' => Carbon::now(),
            'estatus' => 1,
            'role' => 0,
        ]);

        $personaId = DB::table('personas')->insertGetId([
            'nombre_completo' => 'Administrador',
            'fecha_nacimiento' => Carbon::now(),
            'cp' => '00000',
        ]);

        DB::table('empleados')->insert([
            'persona_id' => $personaId,
            'user_id' => $userId,
            'tienda_id' => 0, // Considera usar null si no aplica
            'estatus' => 1,
        ]);
    }
}
