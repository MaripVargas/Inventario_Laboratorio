<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventario;

class MicrobiologiaController extends Controller
{
    public function index()
    {
        $items = Inventario::where('lab_module', 'microbiologia')
                          ->orderBy('created_at', 'desc')
                          ->paginate(10);
        return view('labs.microbiologia.index', [
            'items' => $items,
            'createRouteName' => 'microbiologia.create',
            'editBasePath' => 'inventario',
            'storeRouteName' => 'inventario.store',
            'updateRouteName' => 'inventario.update',
            'destroyRouteName' => 'inventario.destroy',
        ]);
    }

    public function create()
    {
        // Obtener lista de responsables únicos con su cédula de la base de datos
        $responsablesDb = Inventario::select('nombre_responsable', 'cedula')
            ->whereNotNull('nombre_responsable')
            ->where('nombre_responsable', '!=', '')
            ->groupBy('nombre_responsable', 'cedula')
            ->orderBy('nombre_responsable')
            ->get();

        // Responsables por defecto (catálogo base)
        $defaultResponsables = collect([
            ['nombre_responsable' => 'Carolina', 'cedula' => '1234567890'],
            ['nombre_responsable' => 'Maria',    'cedula' => '0987654321'],
            ['nombre_responsable' => 'Alcy',     'cedula' => '1122334455'],
            ['nombre_responsable' => 'Yoli',     'cedula' => '5544332211'],
        ]);

        // Combinar y asegurar unicidad
        $responsables = $defaultResponsables->merge($responsablesDb)->unique(function ($item) {
            return is_array($item) ? $item['nombre_responsable'] : $item->nombre_responsable;
        })->sortBy(function ($item) {
            return is_array($item) ? $item['nombre_responsable'] : $item->nombre_responsable;
        });

        return view('labs.microbiologia.create', [
            'backRouteName' => 'microbiologia.index',
            'storeRouteName' => 'inventario.store',
            'responsables' => $responsables
        ]);
    }
}


