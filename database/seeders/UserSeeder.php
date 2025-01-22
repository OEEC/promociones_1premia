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
        DB::table('users')->insert([
            'name' => 'Oescobar',
            'email' => 'innovacion3@gasamigas.com',
            'password' => Hash::make('123456789'),
            'created_at' => Carbon::now(),
            'estatus' =>  1,
        ]);
    }
}
