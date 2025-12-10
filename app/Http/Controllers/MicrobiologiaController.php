<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InventarioExport;

class MicrobiologiaController extends Controller
{

    public function index(Request $request)
    {
        $labModule = 'microbiologia';
        
        // Consulta base
        $query = Inventario::where('lab_module', $labModule);

        // 🔍 Filtro por tipo de material
        if ($request->filled('tipo_material')) {
            $tipoMaterial = $request->tipo_material;
            // Soportar variaciones: Mueblería/Muebles, Vidrieria/Vidriería
            if ($tipoMaterial == 'Muebles' || $tipoMaterial == 'Mueblería') {
                $query->where(function($q) {
                    $q->where('tipo_material', 'Mueblería')
                      ->orWhere('tipo_material', 'Muebles');
                });
            } elseif ($tipoMaterial == 'Vidriería' || $tipoMaterial == 'Vidrieria') {
                $query->where(function($q) {
                    $q->where('tipo_material', 'Vidrieria')
                      ->orWhere('tipo_material', 'Vidriería');
                });
            } else {
                $query->where('tipo_material', $tipoMaterial);
            }
        }
        
        // 🔹 Filtrado por cuentadante (nombre del responsable)
        if ($request->filled('nombre_responsable')) {
            $query->where('nombre_responsable', $request->nombre_responsable);
        }

        // 🔢 Filtro por placa
        if ($request->filled('no_placa')) {
            $query->where('no_placa', 'like', "%{$request->no_placa}%");
        }

        // 🔎 Filtro de búsqueda
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($subquery) use ($buscar) {
                $subquery->where('ir_id', 'like', "%{$buscar}%")
                         ->orWhere('desc_sku', 'like', "%{$buscar}%")
                         ->orWhere('descripcion_elemento', 'like', "%{$buscar}%");
            });
        }

        // Paginar y mantener parámetros de filtro
        $items = $query->orderBy('created_at', 'desc')
                      ->paginate(10)
                      ->appends($request->all());

        return view('labs.microbiologia.index', [
            'items' => $items,
            'labModule' => $labModule,
            'createRouteName' => 'microbiologia.create',
            'editBasePath' => 'inventario',
            'storeRouteName' => 'inventario.store',
            'updateRouteName' => 'inventario.update',
            'destroyRouteName' => 'inventario.destroy',
        ]);
    }

      public function create()
{
    // 1. Responsables por defecto (lista maestra)
    $defaultResponsables = collect([
        ['nombre_responsable' => 'Alcy Rene Ceron', 'cedula' => '76316028'],
        ['nombre_responsable' => 'Carolina Avila Cubillos', 'cedula' => '28551046'],
        ['nombre_responsable' => 'Eduardo Pastrana Granado', 'cedula' => '7719513'],
        ['nombre_responsable' => 'Kathryn Yadira Pacheco Guzman', 'cedula' => '38142927'],
        ['nombre_responsable' => 'Maria Goretti Ramirez', 'cedula' => '52962110'],
        ['nombre_responsable' => 'Sonia Carolina Delgado Murcia', 'cedula' => '1083883606'],
        ['nombre_responsable' => 'Yoly Dayana Moreno Ortega', 'cedula' => '34327134'],
    ]);

    // 2. Cédulas válidas (solo las reales)
    $cedulasValidas = $defaultResponsables->pluck('cedula')->toArray();

    // 3. Obtener responsables adicionales de BD (excluyendo cédulas de prueba)
    $responsablesDb = Inventario::select('nombre_responsable', 'cedula')
        ->whereNotNull('nombre_responsable')
        ->where('nombre_responsable', '!=', '')
        ->whereNotNull('cedula')
        ->where('cedula', '!=', '')
        ->whereNotIn('cedula', $cedulasValidas)  // Excluir los que ya están en defaults
        ->where('cedula', 'NOT LIKE', '%123456%') // 🔥 Excluir cédulas obvias de prueba
        ->where('cedula', 'NOT LIKE', '%0987654%')
        ->distinct()
        ->get()
        ->map(function ($item) {
            return [
                'nombre_responsable' => $this->normalizarNombre($item->nombre_responsable),
                'cedula' => trim($item->cedula),
            ];
        })
        ->unique('cedula');

    // 4. Combinar: defaults + adicionales de BD
    $responsables = $defaultResponsables
        ->concat($responsablesDb)
        ->sortBy('nombre_responsable')
        ->values();


    // Crear el catálogo con los datos necesarios para el formulario
    $catalogo = [
        'tipos_material' => ['Equipos', 'Mueblería', 'Vidrieria'],
        'estados' => ['bueno', 'regular', 'malo'],
        'gestiones' => ['GESTIONADO', 'SIN GESTIONAR'],
        'vinculaciones' => ['Funcionario Administrativo', 'Contrato', 'Provicional']
    ];

    return view('inventario.create', [
        'labModule' => 'microbiologia',
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


