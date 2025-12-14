<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Crise;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{

    use SoftDeletes;

    public $fillable = [
        'id',
        'email',
    ];

    protected $hidden = [
        'password',
        'token'
    ];

    public function notes()
    {
        return $this->hasMany(Crise::class);
    }
}
