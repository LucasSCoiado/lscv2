<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UserController extends Controller
{
    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
                'txt_name' => 'required|min:3|max:50',
                'txt_email' => 'required|email|max:100',
                'txt_password' => 'required|min:6|max:20|confirmed',
            ],
            [
                'txt_name.required' => 'O nome é obrigatório.',
                'txt_name.min' => 'O nome deve ter pelo menos 3 caracteres.',
                'txt_name.max' => 'O nome não pode ter mais de 50 caracteres.',
                'txt_email.required' => 'O email é obrigatório.',
                'txt_email.email' => 'O email deve ser um endereço de email válido.',
                'txt_email.max' => 'O email não pode ter mais de 100 caracteres.',
                'txt_password.required' => 'A senha é obrigatória.',
                'txt_password.min' => 'A senha deve ter pelo menos 6 caracteres.',
                'txt_password.max' => 'A senha não pode ter mais de 20 caracteres.',
                'txt_password.confirmed' => 'As senhas não coincidem.',
                'txt_password_confirmation.min' => 'A senha deve ter pelo menos 6 caracteres.',
                'txt_password_confirmation.max' => 'A senha não pode ter mais de 20 caracteres.',
                'txt_password_confirmation.confirmed' => 'As senhas não coincidem.',
            ]
        );
        $user = new User();
        $user->email = $request->input('txt_email');
        $user->password = bcrypt($request->input('txt_password'));
        $user->save();

        return redirect()->route('login');
    }
}
