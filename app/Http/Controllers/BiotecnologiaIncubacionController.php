<?php

namespace App\Http\Controllers;

use App\Exports\BiotecnologiaIncubacionExport;
use App\Models\BiotecnologiaIncubacion;
use App\Models\Inventario;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class BiotecnologiaIncubacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $items = $this->filteredQuery($request)
            ->orderByDesc('created_at')
            ->paginate(10)
            ->appends($request->all());

        return view('labs.biotecnologia.incubacion.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $catalogos = $this->getCatalogos();
        return view('labs.biotecnologia.incubacion.create', compact('catalogos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ir_id' => 'required|string|max:255|unique:biotecnologia_incubacion',
            'iv_id' => 'nullable|string|max:255',
            'cod_regional' => 'required|string|max:255',
            'cod_centro' => 'required|string|max:255',
            'desc_almacen' => 'required|string|max:255',
            'no_placa' => 'required|string|max:255',
            'consecutivo' => 'required|string|max:255',
            'desc_sku' => 'required|string|max:255',
            'descripcion_elemento' => 'required|string',
            'atributos' => 'nullable|string',
            'serial' => 'nullable|string|max:255',
            'fecha_adq' => 'required|date',
            'valor_adq' => 'required|numeric|min:0',
            'gestion' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'estado' => 'required|in:bueno,regular,malo',
            'tipo_material' => 'required|string|max:50',
            'uso' => 'required|string|max:255',
            'contrato' => 'required|string|max:255',
            'nombre_responsable' => 'nullable|string|max:255',
            'cedula' => 'nullable|string|max:50',
            'vinculacion' => 'nullable|string|max:255',
            'usuario_registra' => 'required|string|max:255',
        ]);

        $data = $request->all();

        // Manejar la subida de la foto
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $nombreFoto = time() . '_' . $foto->getClientOriginalName();
            $foto->move(public_path('uploads/biotecnologia_incubacion'), $nombreFoto);
            $data['foto'] = $nombreFoto;
        }

        BiotecnologiaIncubacion::create($data);

        return redirect()->route('biotecnologia.incubacion.index')
                        ->with('success', 'Item agregado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $item = BiotecnologiaIncubacion::findOrFail($id);
        return view('labs.biotecnologia.incubacion.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $item = BiotecnologiaIncubacion::findOrFail($id);
        $catalogos = $this->getCatalogos();
        return view('labs.biotecnologia.incubacion.edit', compact('item', 'catalogos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $item = BiotecnologiaIncubacion::findOrFail($id);

        $request->validate([
            'ir_id' => 'required|string|max:255|unique:biotecnologia_incubacion,ir_id,' . $id,
            'iv_id' => 'nullable|string|max:255',
            'cod_regional' => 'required|string|max:255',
            'cod_centro' => 'required|string|max:255',
            'desc_almacen' => 'required|string|max:255',
            'no_placa' => 'required|string|max:255',
            'consecutivo' => 'required|string|max:255',
            'desc_sku' => 'required|string|max:255',
            'descripcion_elemento' => 'required|string',
            'atributos' => 'nullable|string',
            'serial' => 'nullable|string|max:255',
            'fecha_adq' => 'required|date',
            'valor_adq' => 'required|numeric|min:0',
            'gestion' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'estado' => 'required|in:bueno,regular,malo',
            'tipo_material' => 'required|string|max:50',
            'uso' => 'required|string|max:255',
            'contrato' => 'required|string|max:255',
            'nombre_responsable' => 'nullable|string|max:255',
            'cedula' => 'nullable|string|max:50',
            'vinculacion' => 'nullable|string|max:255',
            'usuario_registra' => 'required|string|max:255',
        ]);

        $data = $request->all();

        // Manejar la subida de la foto
        if ($request->hasFile('foto')) {
            // Eliminar foto anterior si existe
            if ($item->foto && file_exists(public_path('uploads/biotecnologia_incubacion/' . $item->foto))) {
                unlink(public_path('uploads/biotecnologia_incubacion/' . $item->foto));
            }

            $foto = $request->file('foto');
            $nombreFoto = time() . '_' . $foto->getClientOriginalName();
            $foto->move(public_path('uploads/biotecnologia_incubacion'), $nombreFoto);
            $data['foto'] = $nombreFoto;
        }

        $item->update($data);

        return redirect()->route('biotecnologia.incubacion.index')
                        ->with('success', 'Item actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $item = BiotecnologiaIncubacion::findOrFail($id);

        // Eliminar foto si existe
        if ($item->foto && file_exists(public_path('uploads/biotecnologia_incubacion/' . $item->foto))) {
            unlink(public_path('uploads/biotecnologia_incubacion/' . $item->foto));
        }

        $item->delete();

        return redirect()->route('biotecnologia.incubacion.index')
                        ->with('success', 'Item eliminado exitosamente.');
    }

    public function exportPdf(Request $request)
    {
        $items = $this->filteredQuery($request)
            ->orderBy('ir_id')
            ->get();

        $pdf = Pdf::loadView('exports.biotecnologia.incubacion', [
            'items' => $items,
            'generatedAt' => now(),
        ])->setPaper('A3', 'landscape');

        return $pdf->download('biotecnologia_incubacion_' . now()->format('Y-m-d_His') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $items = $this->filteredQuery($request)
            ->orderBy('ir_id')
            ->get();

        return Excel::download(
            new BiotecnologiaIncubacionExport($items),
            'biotecnologia_incubacion_' . now()->format('Y-m-d_His') . '.xlsx'
        );
    }

    /**
     * Obtener catálogos para los formularios
     */
   private function getCatalogos()
{
    // 1. Lista maestra de responsables (con nombres completos y normalizados)
    $defaultResponsables = collect([
        ['nombre_responsable' => 'Alcy Rene Ceron', 'cedula' => '76316028'],
        ['nombre_responsable' => 'Carolina Avila Cubillos', 'cedula' => '28551046'],
        ['nombre_responsable' => 'Eduardo Pastrana Granado', 'cedula' => '7719513'],
        ['nombre_responsable' => 'Kathryn Yadira Pacheco Guzman', 'cedula' => '38142927'],
        ['nombre_responsable' => 'Maria Goretti Ramirez', 'cedula' => '52962110'],
        ['nombre_responsable' => 'Sonia Carolina Delgado Murcia', 'cedula' => '1083883606'],
        ['nombre_responsable' => 'Yoly Dayana Moreno Ortega', 'cedula' => '34327134'],
    ])->map(function ($item) {
        return [
            'nombre' => trim($item['nombre_responsable']),
            'cedula' => trim($item['cedula']),
        ];
    });

    // 2. Cédulas de defaults (para filtrar duplicados)
    $cedulasDefaults = $defaultResponsables->pluck('cedula')->toArray();

    // 3. Obtener responsables de la tabla de incubación
    $incubacionData = BiotecnologiaIncubacion::select(
        'nombre_responsable',
        'cedula',
        'vinculacion',
        'usuario_registra'
    )->get();

    // 4. Obtener responsables del inventario general
    $inventarioData = Inventario::select(
        'nombre_responsable',
        'cedula',
        'vinculacion',
        'usuario_registra'
    )->get();

    // 5. Combinar ambas fuentes
    $merged = $incubacionData->concat($inventarioData);

    // 6. Responsables de BD (excluyendo defaults y cédulas de prueba)
    $responsablesDb = $merged
        ->filter(function ($item) use ($cedulasDefaults) {
            $cedulaLimpia = trim($item->cedula ?? '');
            $nombreLimpio = trim($item->nombre_responsable ?? '');
            
            return !empty($nombreLimpio)
                && !empty($cedulaLimpia)
                && !in_array($cedulaLimpia, $cedulasDefaults)  // Excluir defaults
                && !str_contains($cedulaLimpia, '123456')       // Excluir cédulas de prueba
                && !str_contains($cedulaLimpia, '0987654');
        })
        ->map(function ($item) {
            return [
                'nombre' => trim($item->nombre_responsable),
                'cedula' => trim($item->cedula),
            ];
        })
        ->unique('cedula');  // Eliminar duplicados por cédula

    // 7. Combinar: defaults primero + adicionales de BD
    $responsables = $defaultResponsables
        ->concat($responsablesDb)
        ->sortBy('nombre')
        ->values();

    // 8. Vinculaciones por defecto
    $defaultVinculaciones = collect([
        'Funcionario Administrativo',
        'Contrato',
        'Planta'
    ]);

    $vinculacionesDb = $merged
        ->pluck('vinculacion')
        ->filter()
        ->map(fn($v) => trim($v))
        ->unique();

    // Combinar vinculaciones por defecto con las de la BD
    $vinculaciones = $defaultVinculaciones
        ->concat($vinculacionesDb)
        ->unique()
        ->sort()
        ->values();

    // 9. Usuarios
    $usuarios = $merged
        ->pluck('usuario_registra')
        ->filter()
        ->map(fn($u) => trim($u))
        ->unique()
        ->sort()
        ->values();

    return [
        'responsables' => $responsables,
        'vinculaciones' => $vinculaciones,
        'usuarios' => $usuarios,
    ];
}
    protected function filteredQuery(Request $request)
    {
        return BiotecnologiaIncubacion::query()
            ->when($request->filled('buscar'), function ($query) use ($request) {
                $buscar = $request->buscar;
                $query->where(function ($subquery) use ($buscar) {
                    $subquery->where('ir_id', 'like', "%{$buscar}%")
                        ->orWhere('desc_sku', 'like', "%{$buscar}%")
                        ->orWhere('descripcion_elemento', 'like', "%{$buscar}%")
                        ->orWhere('no_placa', 'like', "%{$buscar}%");
                });
            })
            ->when($request->filled('tipo_material'), function ($query) use ($request) {
                $query->where('tipo_material', $request->tipo_material);
            })
            ->when($request->filled('no_placa'), function ($query) use ($request) {
                $query->where('no_placa', 'like', "%{$request->no_placa}%");
            })
            ->when($request->filled('nombre_responsable'), function ($query) use ($request) {
                $query->where('nombre_responsable', $request->nombre_responsable);
            });
    }
}


