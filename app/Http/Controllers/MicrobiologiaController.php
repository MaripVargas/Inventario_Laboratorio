<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventario;

class MicrobiologiaController extends Controller
{
    public function index()
    {
        $items = Inventario::orderBy('created_at', 'desc')->paginate(10);
        return view('labs.microbiologia.index', [
            'items' => $items,
        ]);
    }

    public function create()
    {
        return view('labs.microbiologia.create');
    }
}


