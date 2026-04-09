<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medico extends Model
{
    protected $table = 'medicos';

    public $fillable = [
        'nome',
        'especialidade',
        'crm',
        'telefone',
        'user_id',
        'paciente_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pacientes()
    {
        return $this->belongsToMany(
            Paciente::class,
            'medico_paciente'
        );
    }
}
