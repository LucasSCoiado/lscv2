<?php

namespace App\Http\Controllers;

use App\Mail\ConfirmPasswordChange;
use App\Models\Crise;
use App\Models\Medico;
use App\Models\Paciente;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function index()
    {
        //$paciente = Paciente::all();

        $medico = Medico::where('user_id', Auth::user()->id)->first();
        $meusPacientes = $medico ? $medico->pacientes : collect();
        $user = auth()->user();
        $crisesMes = Crise::where('user_id', $user->id)
            ->whereMonth('data', now()->month)
            ->whereYear('data', now()->year)
            ->count();
        return view('user.index', [
            'user' => $user,
            'isAdmin'   => $user->role === 'admin',
            'isMedico'  => $user->role === 'medico',
            'isPaciente' => $user->role === 'paciente',
            'meusPacientes' => $meusPacientes,
            'crisesMes' => $crisesMes
        ]);
    }

    public function alterarSenha($id)
    {
        $user = User::findOrFail($id);

        return view('user.alterar-senha', compact('user'));
    }

    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'antiga' => 'required|min:8|max:16',
            'senha' => 'required|min:8|max:16|different:antiga',
            'confirmar_senha' => 'required|same:senha'
        ]);

        $user = User::findOrFail($id);

        if (!password_verify($request->antiga, $user->password)) {
            return redirect()->back()->with('error', 'Senha atual está incorreta');
        }

        $user->password = bcrypt($request->senha);
        $user->save();

        try {
            Mail::to($user->email)->send(new ConfirmPasswordChange($user->nome));
        } catch (\Exception $e) {
            Log::error(
                "Erro ao enviar email de confirmação de senha",
                [
                    'erro' => $e->getMessage(),
                    'usuario_id' => $user->id
                ]
            );
        }

        return redirect()->route('user.index')->with('success', 'Senha atualizada com sucesso! Verifique seu email para confirmação.');
    }

    public function confirmPass($token)
    {
        $user = User::where('token', $token)->first();

        if (!$user) {
            abort(403, 'Invalid confirmation acount');
        }

        return view('user.alterar-senha');
    }

    public function confirmPassSubmit(Request $request)
    {
        $request->validate([
            'token' => 'required|size:60|string'
        ]);

        $user = User::where('token', $request->token)->first();

        if (!$user) {
            abort(403, 'Usuário invalido ou token expirado');
        }

        $user->token = null;
        $user->email_verified_at = now();
        $user->save();

        return view('user');
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        //dd($user);
        return view('user.alterar-dados', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = User::findOrFail($id);
        $user->nome = $request->nome;
        $user->email = $request->email;
        if ($user->role == 'admin') {
            $user->role = $request->role;
            $user->permissions = $request->permissions;
        }

        $medico = Medico::where('user_id', $user->id)->first();
        if ($medico) {
            $medico->crm = $request->crm;
            $medico->telefone = $request->telefone;
            $medico->especialidade = $request->especialidade;
            $medico->save();
        }
        $paciente = Paciente::where('user_id', $user->id)->first();
        if ($paciente) {
            $paciente->telefone = $request->telefone;
            $paciente->save();
        }
        // $paciente = Paciente::where('user_id', $user->id)->first(); ATUALIZAR DADOS USUARIO PACIENTE
        // if($paciente){

        // }
        if ($request->hasFile('imagem')) {
            $file = $request->file('imagem');
            $path = $file->store('perfil', 'public');
            $user->foto = $path;
        }

        $user->save();

        return redirect()->route('user.index')->with('success', 'Dados atualizados com sucesso!');
    }
}
