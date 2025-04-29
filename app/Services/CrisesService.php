<?php 

namespace App\Services;

use App\Models\Crise;
use App\Models\User;
use Illuminate\Http\Request;

class CrisesService
{
    public static function store($request, $userId)
    {
        $crise = new Crise();
        $crise->tipo = $request->input('txt_tipo');
        $crise->data = $request->input('txt_data');
        $crise->tempo = $request->input('txt_tempo');
        $crise->user_id = $userId;
        $crise->save();

        return $crise;
    }

    public static function update(Request $request)
    {

        if($request->crise_id == null){
            return redirect()->route('home');
        }

        $id = Operations::decrypt($request->crise_id);
        
        $crise = Crise::find($id);
        
        $crise->tipo = $request->txt_tipo;
        $crise->data = $request->txt_data;
        $crise->tempo = $request->txt_tempo;
        $crise->save();

        return $crise;
    }
}