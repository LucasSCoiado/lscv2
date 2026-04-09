<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admins';

    public function medico()
    {
        return $this->hasOne(Medico::class);
    }
}
