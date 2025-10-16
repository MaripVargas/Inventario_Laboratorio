<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InventarioExport;

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


