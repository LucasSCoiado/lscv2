<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PacienteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pacientes')->insert([
            [
                'nome' =>'Paciente A',
                'telefone' => '444444444',
                'idade' => '45',
                'genero' => 'masculino',
                'user_id' => 10
            ],
        ]);
        DB::table('pacientes')->insert([
            [
                'nome' =>'Paciente B',
                'telefone' => '555555555',
                'idade' => '35',
                'genero' => 'feminino',
                'user_id' => 9
            ],
        ]);
        DB::table('pacientes')->insert([
            [
                'nome' =>'Paciente C',
                'telefone' => '444444444',
                'idade' => '25',
                'genero' => 'feminino',
                'user_id' => 8
            ],
        ]);
    }
}
