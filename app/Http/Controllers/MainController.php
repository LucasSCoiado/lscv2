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
        $id = Operations::decrypt($id);
        echo "Deletando o $id";
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
