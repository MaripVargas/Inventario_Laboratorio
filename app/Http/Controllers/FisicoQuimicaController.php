<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FisicoQuimicaController extends Controller
{
    public function index()
    {
        return view('labs.fisicoquimica.index');
    }
}


