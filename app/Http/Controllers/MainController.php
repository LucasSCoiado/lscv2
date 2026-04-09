<?php

namespace App\Http\Controllers;

use App\Models\Crise;
use App\Models\Medico;
use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\User;
use App\Services\Operations;
use App\Services\CrisesService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $crises = $user->notes()->get()->toArray();

        $data = [
            'crises' => $crises,
            'user' => $user,
        ];

        $pacientes = 0;
        $medicos = 0;

        if ($user->role === 'admin') {
            $pacientes = User::withTrashed()->where('role', 'paciente')->count();
            $medicos   = User::withTrashed()->where('role', 'medico')->count();

            $data['pacientes'] = $pacientes;
            $data['medicos'] = $medicos;
        } elseif ($user->role === 'medico') {
            // Para médicos, obter quantidade de pacientes relacionados
            $medico = $user->medico;
            $pacientes = $medico ? $medico->pacientes()->count() : 0;
            $data['pacientes'] = $pacientes;
        }
        $ano = now()->year;
        $crisesMes = Crise::where('user_id', $user->id)
            ->whereMonth('data', now()->month)
            ->whereYear('data', now()->year)
            ->count();
        $crisesPorDia = DB::table('crises')
            ->selectRaw('MONTH(data) as mes, DAY(data) as dia, COUNT(*) as total')
            ->where('user_id', $user->id)
            ->whereYear('data', $ano)
            ->groupBy('mes', 'dia')
            ->get()
            ->groupBy('mes');
        
        $crisesMes = Crise::where('user_id', $user->id);
        $crisesMes = $crisesMes->whereYear('data', $ano)->whereMonth('data', now()->month)->count();
        return view('home', compact('data', 'user', 'crises',
            'crisesMes',
            'ano',
            'crisesPorDia',
            'pacientes',
            'medicos'));
    }


    // public function create()
    // {
    //     return view('create');
    // }

    public function showPaciente($id)
    {
        Auth::user()->can('admin-or-medico') ?: abort(403);

        $paciente = Paciente::findOrFail($id);

        $medico = Medico::all();
        $medico_paciente = $medico->where('paciente_id', $paciente->id)->first();

        $ano = now()->year;

        // crises do PACIENTE agrupadas por mês
        $crisesPorMes = DB::table('crises')
            ->selectRaw('MONTH(created_at) as mes, COUNT(*) as total')
            ->where('user_id', $paciente->user_id)
            ->whereYear('created_at', $ano)
            ->groupBy('mes')
            ->pluck('total', 'mes');

        $crisesPorDia = DB::table('crises')
            ->selectRaw('MONTH(created_at) as mes, DAY(created_at) as dia, COUNT(*) as total')
            ->where('user_id', $paciente->user_id)
            ->whereYear('created_at', $ano)
            ->groupBy('mes', 'dia')
            ->get()
            ->groupBy('mes');

        return view('admin.dados_paciente', compact(
            'paciente',
            'medico_paciente',
            'crisesPorMes',
            'ano',
            'crisesPorDia'
        ));
    }

    public function showMedico($id)
    {
        $medico = Medico::findOrFail($id);
        return view('admin.dados_medico', compact('medico'));
    }

    public function pacientes()
    {
        Auth::user()->can('admin-or-medico') ?: abort(403, 'Você não tem autorização para acesso a esta pagina');

        $pacientes = Paciente::all();

        $meusPacientes = $pacientes;

        if (Auth::user()->role === "medico") {
            $medico = Medico::where('user_id', Auth::user()->id)->first();
            $meusPacientes = $medico ? $medico->pacientes : collect();
        }


        $pacientes = Paciente::withCount('crises')->get();

        // preparar array id => crises_count para a view
        $crises = $pacientes->pluck('crises_count', 'id')->toArray();

        return view('user.pacientes', compact('pacientes', 'crises', 'meusPacientes'));
    }

    // public function store(Request $request)
    // {
    //     $this->validate($request);

    //     CrisesService::store($request, Auth::id());

    //     return redirect()->route('home');
    // }

    // public function edit($id)
    // {
    //     $id = Operations::decrypt($id);

    //     if ($id === null) {
    //         return redirect()->route('home');
    //     }

    //     $crise = Crise::FindOrFail($id);

    //     return view('update', [
    //         'crise' => $crise,
    //     ]);
    // }

    // public function update(Request $request)
    // {
    //     $this->validate($request);

    //     CrisesService::update($request);

    //     return redirect()->route('home');
    // }

    public function delete($id)
    {
        try {
            $id = Operations::decrypt($id);

            if ($id === null) {
                return redirect()->route('home');
            }

            $crise = Crise::find($id);

            if (!$crise) {
                return redirect()->route('home')->with('error', 'Crise não encontrada.');
            }

            return view('delete', [
                'crises' => $crise,
            ]);
        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'ID inválido.' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $id = Operations::decrypt($id);

        if ($id === null) {
            return redirect()->route('home');
        }

        Crise::destroy($id);

        return redirect()->route('home');
    }

    public function allPacientes()
    {
        Auth::user()->can('admin-or-mAdmin') ?: abort(403, 'Você não tem autorização para acesso a esta pagina');

        $pacientes = Paciente::with('medicos.user')->get();
        return view('pacientes', compact('pacientes'));
    }

    private function validate(Request $request)
    {
        $request->validate(
            [
                'txt_tipo' => 'required|min:3|max:255',
                'txt_data' => 'required|date',
                'txt_tempo' => 'required|min:3|max:255',
            ],
            [
                'txt_tipo.required' => 'O tipo é obrigatorio',
                'txt_tipo.min' => 'O tipo deve ter no mínimo :min caractéres',
                'txt_tipo.max' => 'O tipo deve ter no máximo :max caractéres',

                'txt_data.required' => 'A data é obrigatoria',

                'txt_tempo.required' => 'O tempo é obrigatório',
                'txt_tempo.min' => 'O tempo deve ter no mínimo :min caractéres',
                'txt_tempo.max' => 'O tempo deve ter no máximo :max caractéres'
            ]
        );
    }
}
