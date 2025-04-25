<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\User;

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

    public function newCrise()
    {
        echo 'newCrise';
    }
}
