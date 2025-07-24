<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Crise;

class User extends Model
{

    public $fillable = [
        'id',
        'email',
        'password'
    ];

    public function notes()
    {
        return $this->hasMany(Crise::class);
    }
}
