<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Model;
use App\Models\Crise;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    use SoftDeletes;

    public $fillable = [
        'id',
        'email',
        'nome',
        'role',
        'foto',
    ];

    protected $hidden = [
        'password',
        'token'
    ];

    public function notes()
    {
        return $this->hasMany(Crise::class);
    }

    public function crises()
    {
        return $this->hasMany(Crise::class);
    }

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    public function paciente()
    {
        return $this->hasOne(Paciente::class);
    }

    public function medico()
    {
        return $this->hasOne(Medico::class);
    }
}
