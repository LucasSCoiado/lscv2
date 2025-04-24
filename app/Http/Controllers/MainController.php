<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class MainController extends Controller
{
    public function index()
    {
        return view('/home');
    }

    public function newCrise()
    {
        echo 'newCrise';
    }
}
