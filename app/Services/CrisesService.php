<?php 

namespace App\Services;

use App\Models\Crise;
use App\Models\User;
use Illuminate\Http\Request;

class CrisesService
{
    public function getCrisesByUserId($userId)
    {
        return User::find($userId)->notes()->get()->toArray();
    }

    public static function createCrise($request, $userId)
    {
        // Cria uma nova instância de Crise
        $crise = new Crise();
        $crise->tipo = $request->input('txt_tipo');
        $crise->data = $request->input('txt_data');
        $crise->tempo = $request->input('txt_tempo');
        $crise->user_id = $userId; // Relaciona com o usuário logado
        $crise->save();

        return $crise; // Retorna a instância criada
    }
}