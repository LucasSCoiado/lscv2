<?php 

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;

class UserService
{
    public static function store(Request $request)
    {
        $user = User::create([
            'email' => $request->txt_email,
            'password' => bcrypt($request->txt_password),
        ]);

        return $user;
    }

}