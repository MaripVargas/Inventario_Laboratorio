<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventario;

class BiotecnologiaController extends Controller
{
    public function index()
    {
        $items = Inventario::orderBy('created_at', 'desc')->paginate(10);
        return view('labs.biotecnologia.index', [
            'items' => $items,
        ]);
    }

    public function create()
    {
        return view('labs.biotecnologia.create');
    }
}


