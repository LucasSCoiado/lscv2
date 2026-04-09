<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paciente extends Model
{
    protected $table = 'pacientes';

    use SoftDeletes;

    public $fillable = [
        'nome',
        'idade',
        'telefone',
        'genero',
        'user_id'
    ];

    public function crises()
    {
        // crises table stores the related user_id, so join on pacientes.user_id = crises.user_id
        return $this->hasMany(Crise::class, 'user_id', 'user_id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function medicos()
    {
        return $this->belongsToMany(
            Medico::class,
            'medico_paciente'
        );
    }
}
