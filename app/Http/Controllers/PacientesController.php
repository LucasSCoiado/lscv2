<?php

namespace App\Http\Controllers;

use App\Models\Crise;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Services\CrisesService;
use App\Services\Operations;

class PacientesController
{
    public function index()
    {
        $user = Auth::user();
        $ano = now()->year;
        $hoje = now();

        /*
    |--------------------------------------------------------------------------
    | CRISES DO MÊS ATUAL
    |--------------------------------------------------------------------------
    */

        $crisesMes = Crise::where('user_id', $user->id)
            ->whereMonth('data', $hoje->month)
            ->whereYear('data', $ano)
            ->get();

        // Agrupamento mensal (para lista horizontal)
        $crisesPorDiaMes = $crisesMes->groupBy(function ($crise) {
            return Carbon::parse($crise->data)->day;
        });

        $diasNoMes = $hoje->daysInMonth;
        $listaDias = [];

        for ($dia = 1; $dia <= $diasNoMes; $dia++) {
            $listaDias[$dia] = isset($crisesPorDiaMes[$dia])
                ? count($crisesPorDiaMes[$dia])
                : 0;
        }

        $totalMes = $crisesMes->count();

        /*
    |--------------------------------------------------------------------------
    | CALENDÁRIO ANUAL
    |--------------------------------------------------------------------------
    */

        $crisesAno = Crise::where('user_id', $user->id)
            ->whereYear('data', $ano)
            ->get();

        $crisesPorDiaAno = [];

        foreach ($crisesAno as $crise) {

            $data = Carbon::parse($crise->data);
            $mes = $data->month;
            $dia = $data->day;

            if (!isset($crisesPorDiaAno[$mes])) {
                $crisesPorDiaAno[$mes] = [];
            }

            $index = collect($crisesPorDiaAno[$mes])
                ->search(fn($item) => $item['dia'] == $dia);

            if ($index !== false) {

                $crisesPorDiaAno[$mes][$index]['total']++;
                $crisesPorDiaAno[$mes][$index]['ids'][] = $crise->id;
            } else {

                $crisesPorDiaAno[$mes][] = [
                    'dia' => $dia,
                    'total' => 1,
                    'ids' => [$crise->id]   // 👈 guarda o id
                ];
            }
        }

        return view('crises.index', compact(
            'listaDias',
            'totalMes',
            'crisesPorDiaAno',
            'ano'
        ));
    }

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $this->validate($request);

        CrisesService::store($request, Auth::id());

        return redirect()->route('home');
    }

    public function edit($id)
    {
        $id = Operations::decrypt($id);

        if ($id === null) {
            return redirect()->route('home');
        }

        $crise = Crise::FindOrFail($id);

        return view('update', [
            'crise' => $crise,
        ]);
    }

    public function update(Request $request)
    {
        $this->validate($request);

        CrisesService::update($request);

        return redirect()->route('home');
    }

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

    // when called from the calendar we may receive no id but instead query parameters
    public function dadosCrise(Request $request, $id = null)
    {
        if ($id) {

            $crises = Crise::find($id)
                            ->where('user_id', Auth::id())
                            ->first();

            if (!$crises) {
                return redirect()->route('home')->with('error', 'Crise não encontrada.');
            }

            return view('dados-crise', [
                'crises' => $crises,
            ]);
        }
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
