<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Mail\NewUserConfirmation;
use App\Models\Crise;
use App\Models\Medico;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    // pacientes

    public function cadastrarPaciente()
    {
        Auth::user()->can('admin-or-medico')?:abort(403, 'Não tem autorização para entrar nesta página!');
        return view('admin.create_paciente');
    }

    public function storePaciente(Request $request)
    {
        Auth::user()->can('admin-or-medico') ?: abort(403);

        $request->validate([
            'nome' => 'required|string|max:255',
            'nome_usuario' => 'required|string|max:255',
            'idade' => 'required|integer',
            'genero' => 'required|string|max:50',
            'telefone' => 'required|string|max:11',
            'email' => 'required|email|unique:users',
            'foto' => 'nullable|image|max:2048',
        ]);

        // 1 Gerar senha em texto e criar o usuário
        $plainPassword = Str::random(8);

        $user = User::create([
            'nome' => $request->nome_usuario,
            'email' => $request->email,
            'password' => bcrypt($plainPassword),
            'role' => 'paciente',
            'permissions' => 'paciente'
        ]);
        // gerar token de confirmação (string simples de 60 chars)
        $token = Str::random(60);
        $user->token = $token;
        $user->save();
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('avatars', 'public');
            $user->foto = $path;
            $user->save();
        }
        $confirmationLink = route('confirm.account', ['token' => $token]);
        $genero = strtolower($request->genero);
        // 2 Criar o paciente ligado ao usuário
        Paciente::create([
            'user_id' => $user->id, // 🔥 ESSENCIAL
            'nome' => $request->nome,
            'telefone' => $request->telefone,
            'idade' => $request->idade,
            'genero' => strtolower($genero),
        ]);

        // 3 Enviar e-mail com senha atual e link para definir/recuperar senha
        //fazer link de confirmação ou edição de senha
        

        try {
            Mail::to($user->email)->send(new NewUserConfirmation($user->email, $confirmationLink, $plainPassword));
        } catch (\Exception $e) {
            // Falha ao enviar e-mail — não interrompe o fluxo de criação
        }

        return redirect()
            ->route('admin.pacientes')
            ->with('success', 'Paciente cadastrado com sucesso!');
    }

    public function editPacientes($id)
    {
        $paciente = Paciente::findOrFail($id);

        if (!(Auth::user() && (Auth::user()->can('admin-or-medico') || Auth::id() === $paciente->user_id))) {
            abort(403, 'Você não tem autorização para acesso a esta página');
        }

        return view('admin.edit_paciente', compact('paciente'));
    }

    public function updatePaciente(Request $request, $id)
    {
        $paciente = Paciente::findOrFail($id);

        if (!(auth()->check() && (auth()->user()->can('admin-or-medico') || auth()->id() === $paciente->user_id))) {
            abort(403);
        }

        Log::info('AdminController@updatePaciente called', [
            'route_id' => $id,
            'paciente_id' => $paciente->id,
            'paciente_user_id' => $paciente->user ? $paciente->user->id : null,
            'request_input' => $request->all(),
        ]);

        $request->validate([
            'nome' => 'required|string|max:255',
            'nome_usuario' => 'required|string|max:255',
            'idade' => 'required|integer',
            'genero' => 'required|in:masculino,feminino',
            'telefone' => 'required|string|max:11',
            'email' => 'required|email|unique:users,email,' . $paciente->user->id,
        ]);

        try {
            DB::transaction(function () use ($paciente, $request) {
                if ($paciente->user) {
                    $paciente->user->update([
                        'nome' => $request->nome_usuario,
                        'email' => $request->email,
                    ]);
                } else {
                    Log::warning('Paciente has no linked user record', ['paciente_id' => $paciente->id]);
                }

                $paciente->update([
                    'nome' => $request->nome,
                    'telefone' => $request->telefone,
                    'idade' => $request->idade,
                    'genero' => strtolower($request->genero),
                ]);
            });

            Log::info('AdminController@updatePaciente success', ['paciente_id' => $paciente->id]);

            return redirect()
                ->route('admin.pacientes')
                ->with('success', 'Paciente atualizado com sucesso!');
        } catch (\Exception $e) {
            Log::error('AdminController@updatePaciente error', ['message' => $e->getMessage(), 'paciente_id' => $paciente->id]);
            return redirect()->back()->with('error', 'Erro ao atualizar paciente: ' . $e->getMessage());
        }
    }

    public function deletarPacientes($id)
    {
        Auth::user()->can('admin') ?: abort(403);

        $paciente = Paciente::findOrFail($id);
        $user = $paciente->user; // 👈 relacionamento

        return view('admin.delete_users', compact('paciente', 'user'));
    }

    public function destroyPacientes($id)
    {
        Auth::user()->can('admin') ?: abort(403);

        $paciente = Paciente::findOrFail($id);

        DB::transaction(function () use ($paciente) {

            // soft delete do paciente
            $paciente->delete();

            // soft delete do usuário vinculado
            if ($paciente->user) {
                $paciente->user->delete();
            }
        });

        return redirect()
            ->route('admin.pacientes')
            ->with('success', 'Paciente removido com sucesso!');
    }

    public function updateFoto(Request $request, $id)
    {
        Auth::user()->can('admin-or-medico') ?: abort(403);

        $paciente = Paciente::findOrFail($id);

        $request->validate([
            'foto' => 'required|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('avatars', 'public');
            if ($paciente->user) {
                $paciente->user->foto = $path;
                $paciente->user->save();
            }
        }

        return redirect()->back()->with('success', 'Foto atualizada com sucesso!');
    }

    // médicos
    public function medicos()
    {
        Auth::user()->can('admin-or-mAdmin')?:abort(403,'Você não tem autorização para acesso a esta pagina');

        $medicos = Medico::all();

        return view('user.medicos', compact('medicos'));
    }

    public function cadastrarMedico()
    {
        Auth::user()->can('admin')?:abort(403, 'Não possui autorização de acesso a página');
        return view('admin.creade_medico');
    }

    public function storeMedico(Request $request)
    {
        Auth::user()->can('admin')?:abort(403);

        $request->validate([
            'nome' => 'required|string|max:255',
            'nome_usuario' => 'required|string|max:255',
            'especialidade' => 'required|string|max:255',
            'telefone' => 'required|string|max:11',
            'email' => 'required|email|unique:users',
            'foto' => 'nullable|image|max:2048',
        ]);
        $plainPassword = Str::random(8);

        $user = User::create([
            'nome' => $request->nome_usuario,
            'email' => $request->email,
            'password' => bcrypt($plainPassword),
            'role' => 'medico',
            'permissions' => strtolower($request->permissoes)
        ]);
        $token = Str::random(60);
        $user->token = $token;
        $user->save();
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('avatars', 'public');
            $user->foto = $path;
            $user->save();
        }
        $confirmationLink = route('confirm.account', ['token' => $token]);

        Medico::create([
            'user_id' => $user->id,
            'nome' => $request->nome,
            'crm' => $request->crm,
            'especialidade' => $request->especialidade,
            'telefone' => $request->telefone
        ]);
        try {
            Mail::to($user->email)->send(new NewUserConfirmation($user->email, $confirmationLink, $plainPassword));
        } catch (\Exception $e) {
            // Falha ao enviar e-mail — não interrompe o fluxo de criação
            Log::error('Erro ao enviar email', 
        [
                    'erro' => $e->getMessage(),
                ]
            );
        }

        return redirect()->route('admin.medicos')->with('success', 'Médico cadastrado com sucesso!');
    }

    public function editMedicos($id)
    {
        Auth::user()->can('admin')?:abort(403,'Você não tem acesso a esta página');
        $medico = Medico::findOrFail($id);
        //dd($medico);
        return view('admin.edit_medico', compact('medico'));
    }

    public function updateMedicos(Request $request, $id)
    {
        abort_unless(Auth::user()->can('admin'), 403);

        $request->validate([
            'nome' => 'required|string|max:255',
            'especialidade' => 'required|string|max:255',
            'telefone' => 'required|string|max:11',
        ]);

        $medico = Medico::findOrFail($id);

        $medico->user->update([
            'nome' => $request->nome_usuario,
            'email' => $request->email,
        ]);

        $medico->update([
            'nome' => $request->nome,
            'crm' => $request->crm,
            'especialidade' => $request->especialidade,
            'telefone' => $request->telefone,
        ]);

        return redirect()
            ->route('admin.medicos')
            ->with('success', 'Médico atualizado com sucesso!');
    }

    public function deleteMedicos($id)
    {
        Auth::user()->can('admin') ?: abort(403);

        $medico = Medico::findOrFail($id);
        $user = $medico->user; // 👈 relacionamento

        return view('admin.delete_users', compact('medico', 'user'));
    }

    public function destroyMedicos($id)
    {
        Auth::user()->can('admin') ?: abort(403);

        $medico = Medico::findOrFail($id);

        DB::transaction(function () use ($medico) {

            // soft delete do paciente
            $medico->delete();

            // soft delete do usuário vinculado
            if ($medico->user) {
                $medico->user->delete();
            }
        });

        return redirect()
            ->route('admin.medicos')
            ->with('success', 'Medico removido com sucesso!');
    }
}
