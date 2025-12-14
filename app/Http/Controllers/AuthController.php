<?php

namespace App\Http\Controllers;

use App\Mail\ResetPassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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

    public function forgotPassword()
    {
        return view('auth.forgot_password');
    }

    public function sendRessetPasswordLink(Request $request)
    {
        // validação
        $request->validate([
            'email' => 'required|email'
            ],[
             'email.required' => 'O email é obrigatório',
             'email.email' => 'Deve ser endereço de email válido',
            ]
        );

        $generic_message = "Verifique seu email para prosseguir com a recuperação da senha";
        
        // verificar se email existe
        $user = User::where('email', $request->email)->first();
        if(!$user){
            $generic_message = "Este e-mail não esta cadastrado no sistema";
            return back()->with([
                'server_message' => $generic_message
            ]);
        }

        // criar link com token para envio ao email
        $user->token = Str::random(64);

        $token_link = route('reset_password', ['token' => $user->token]);
        $result = Mail::to($user->email)->send(new ResetPassword($user->email, $token_link));

        // verifica envio
        if(!$result){
            return back()->with([
                'server_message' => $generic_message
            ]);
        }

        $user->save();

        return back()->with([
            'server_message' => $generic_message
        ]);
    }

    public function reset_password($token)
    {
        $user = User::where('token', $token);

        if(!$user){
            return redirect()->route('login');
        }
        return view('auth.reset_password', ['token'=>$token]);
    }

    public function reset_password_update(Request $request)
    {
        $request->validate(
        [
            'token' => 'required',
            'new_password' =>'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/|different:current_password',
            'new_password_confirmation' => 'required|same:new_password'
        ],
        [
            'new_password.required' => 'A senha não foi informada',
            'new_password.min' => 'A senha tem no mínimo :min caracteres',
            'new_password.regex' => 'Deve ter pelo menos uma letra maiúscula, uma letra minúscula e um caractere',
            'new_password.different' => 'A nova senha deve ser diferente da senha atual',
            'new_password_confirmation.required' => 'A confirmação da senha não foi informada',
            'new_password_confirmation.same' => 'A confirmação da senha deve ser igual a senha',
        ]);

        // verifica se token é valido
        $user = User::where('token', $request->token)->first();
        if(!$user){
            return redirect()->route('login');
        }
        $user->password = bcrypt($request->new_password);
        $user->token = null;

        $user->save();
        return redirect()->route('login')->with(['success'=>true]);
    }

}
