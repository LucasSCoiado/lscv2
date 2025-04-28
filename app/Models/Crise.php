<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; 
use App\Models\User;


class Crise extends Model
{

    protected $fillable = [
        'tipo',
        'data',
        'tempo',
        'user_id'
    ];
    protected $table = 'crises';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
