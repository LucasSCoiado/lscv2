<?php

namespace App\Http\Controllers\Update;

use Illuminate\Http\Request;
use Inertia\Inertia;

class MainController
{
    public function index()
    {
        return Inertia::render('Home');
    }
}
