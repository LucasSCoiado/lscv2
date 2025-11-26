<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'email' =>'teste1@gmail.com',
                'password' => bcrypt('abc123456'),
                'created_at' => date('Y-m-d H:i:s'),
                'role' => 'Paciente',
                'token' => Str::random(60),
                'permissions' => '["paciente"]'
            ],
            [
                'email' =>'teste2@gmail.com',
                'password' => bcrypt('abc123456'),
                'created_at' => date('Y-m-d H:i:s'),
                'role' => 'Paciente',
                'token' => Str::random(60),
                'permissions' => '["paciente"]'
            ],
            [
                'email' =>'teste3@gmail.com',
                'password' => bcrypt('abc123456'),
                'created_at' => date('Y-m-d H:i:s'),
                'role' => 'Médico',
                'token' => Str::random(60),
                'permissions' => '["medico"]'
            ],
        ]);
    }
}
