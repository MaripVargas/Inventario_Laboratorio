<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventario;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index()
    {
        $stats = [
            'total_items' => Inventario::count(),
            'gestiones' => Inventario::distinct('gestion')->count('gestion'),
            'estado_malo' => Inventario::where('estado', 'malo')->count(),
        ];
        
        // Obtener todos los items del inventario para mostrar en la tabla
        $inventario = Inventario::orderBy('created_at', 'desc')->get();
        
        return view('dashboard', compact('stats', 'inventario'));
    }
}
