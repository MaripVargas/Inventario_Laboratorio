<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MicrobiologiaController extends Controller
{
    public function index()
    {
        return view('labs.microbiologia.index');
    }
}


