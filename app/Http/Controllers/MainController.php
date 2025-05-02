<?php

namespace App\Http\Controllers;

use App\Models\Crise;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\User;
use App\Services\Operations;
use App\Services\CrisesService;

class MainController extends Controller
{
    public function index()
    {
        $id = session('user.id');
        $crises = User::find($id)->notes()->get()->toArray();

        return view('/home', [
            'crises' => $crises,
        ]);
    }

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $this->validate($request);
        
        CrisesService::store($request, session('user.id'));

        return redirect()->route('home');
    }

    public function edit($id)
    {
        $id = Operations::decrypt($id);
        
        if($id === null){
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

            if($id === null){
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
            return redirect()->route('home')->with('error', 'ID inválido.' .$e->getMessage());
        }
    }

    public function destroy($id)
    {
        $id = Operations::decrypt($id);

        if($id === null){
            return redirect()->route('home');
        }

        Crise::destroy($id);

        return redirect()->route('home');
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
