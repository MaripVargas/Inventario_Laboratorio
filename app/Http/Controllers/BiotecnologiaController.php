<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BiotecnologiaController extends Controller
{
    public function index()
    {
        return view('labs.biotecnologia.index');
    }
}


