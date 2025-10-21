<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InventarioExport;


class BiotecnologiaController extends Controller
{
 
    public function index()
    {
        $items = Inventario::where('lab_module', 'biotecnologia_vegetal')
                          ->orderBy('created_at', 'desc')
                          ->paginate(10);
        return view('labs.biotecnologia.index', [
            'items' => $items,
            'createRouteName' => 'biotecnologia.create',
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
        ->get()
        ->map(function($item) {
            return [
                'nombre_responsable' => $item->nombre_responsable,
                'cedula' => $item->cedula
            ];
        });

    // Responsables por defecto (catálogo base)
    $defaultResponsables = collect([
        ['nombre_responsable' => 'Carolina Avila', 'cedula' => '28551046'],
        ['nombre_responsable' => 'Maria Goretti Ramirez', 'cedula' => '0987654321'],
        ['nombre_responsable' => 'Alcy Rene Ceron', 'cedula' => '76316028'],
        ['nombre_responsable' => 'Yoli Dayana Moreno', 'cedula' => '34327134'],
    ]);

    // Combinar y asegurar unicidad - TODOS SON ARRAYS AHORA
    $responsables = $defaultResponsables
        ->concat($responsablesDb)
        ->unique('nombre_responsable')
        ->sortBy('nombre_responsable')
        ->values();

     $catalogo = [
        'tipos_material' => ['Equipos', 'Mueblería', 'Vidrieria'],
        'estados' => ['bueno', 'regular', 'malo'],
        'gestiones' => ['GESTIONADO', 'SIN GESTIONAR'],
        'vinculaciones' => ['Funcionario Administrativo', 'Contrato', 'Provicional']
    ];

    return view('inventario.create', [
        'labModule' => 'biotecnologia_vegetal',
        'responsables' => $responsables,
        'catalogo' => $catalogo
    ]);
}

   
public function exportPdf($modulo)
{
    $inventario = Inventario::where('lab_module', $modulo)->get();
    
    $stats = [
        'total_items' => $inventario->count(),
        'total_value' => $inventario->sum('valor_adq'),
        'estado_bueno' => $inventario->where('estado', 'bueno')->count(),
        'estado_regular' => $inventario->where('estado', 'regular')->count(),
        'estado_malo' => $inventario->where('estado', 'malo')->count(),
        'gestiones' => $inventario->pluck('gestion')->unique()->count(),
    ];
    
    $pdf = PDF::loadView('inventario.pdf', compact('inventario', 'stats'));
    $pdf->setPaper('A4', 'portrait');
    
    return $pdf->download('inventario_' . $modulo . '_' . date('Y-m-d') . '.pdf');
}

public function exportExcel($modulo)
   {
       return Excel::download(new InventarioExport($modulo), 'inventario_' . $modulo . '_' . date('Y-m-d') . '.xlsx');
   }

}


