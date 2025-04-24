<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function loginSubmit(Request $request)
    {
        $request->validate(
    [
                'txt_email' => 'required|email',
                'txt_password' => 'required|min:6|max:20'
            ],
    [
                'txt_email.required' => 'Email obrigatorio',
                'txt_email.email' => 'Deve ser um email valido',
                'txt_password.required' => 'Senha obrigatoria',
                'txt_password.min' => 'Senha de no mínimo :min caracteres',
                'txt_password.max' => 'Senha de no máximo :max caracteres'
            ]
        );

        $email = $request->input('txt_email');
        $password = $request->input('txt_password');
        
        //verificação de email
        $user = User::where('email', $email)
                ->where('deleted_at', null)
                ->first();
        if(!$user) {
            return redirect()->back()->with('loginError', 'Email ou senha incorretos');
        }

        //check de senha
        if(!password_verify($password, $user->password)) {
            return redirect()
                    ->back()
                    ->withInput()
                    ->with('loginError', 'Email ou senha incorretos');
        }

        //update last login
        $user->last_login = date('Y/m/d H:i:s');
        $user->save();

        //login
        session([
            'user'=>[
                'id' => $user->id,
                'email' => $user->email
            ]
        ]);

        return redirect()->to('/');

    }
    public function logout()
    {
        session()->forget('user');
        return redirect()->to('/login');
    }
}
