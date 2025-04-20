<?php

namespace App\Http\Controllers;

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
        try{
            DB::connection()->getPdo();
            echo "Conexão bem sucedida";
        }catch(\PDOException $e){
            echo "conexão falhou " .$e->getMessage();
        }
        echo "FIM";
    }
    public function logout()
    {
        return view('logout');
    }
}
