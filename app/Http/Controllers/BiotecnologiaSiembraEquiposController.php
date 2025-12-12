<?php

namespace App\Http\Controllers;

use App\Exports\BiotecnologiaSiembraEquiposExport;
use App\Models\BiotecnologiaSiembraEquipo;
use App\Models\Inventario;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BiotecnologiaSiembraEquiposController extends Controller
{
    public function index(Request $request)
    {
        $items = $this->filteredQuery($request)
            ->orderByDesc('id')
            ->get();

        return view('labs.biotecnologia.siembra_equipos.index', compact('items'));
    }

    public function create()
    {
        $catalogos = $this->getCatalogos();
        return view('labs.biotecnologia.siembra_equipos.create', compact('catalogos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'cantidad' => 'nullable|integer',
            'unidad' => 'nullable|string|max:100',
            'detalle' => 'nullable|string|max:500',
            'no_placa' => 'nullable|string|max:255',
            'fecha_adq' => 'nullable|date',
            'valor' => 'nullable|numeric|min:0',
            'nombre_responsable' => 'nullable|string|max:255',
            'cedula' => 'nullable|string|max:50',
            'vinculacion' => 'nullable|string|max:255',
            'fecha_registro' => 'nullable|date',
            'usuario_registra' => 'nullable|string|max:255',
        ]);

        BiotecnologiaSiembraEquipo::create($request->all());

        return redirect()->route('biotecnologia.siembra_equipos.index')
                         ->with('success', 'Equipo de siembra agregado correctamente.');
    }

    public function edit($id)
    {
        $item = BiotecnologiaSiembraEquipo::findOrFail($id);
        $catalogos = $this->getCatalogos();
        return view('labs.biotecnologia.siembra_equipos.edit', compact('item', 'catalogos'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'cantidad' => 'nullable|integer',
            'unidad' => 'nullable|string|max:100',
            'detalle' => 'nullable|string|max:500',
            'no_placa' => 'nullable|string|max:255',
            'fecha_adq' => 'nullable|date',
            'valor' => 'nullable|numeric|min:0',
            'nombre_responsable' => 'nullable|string|max:255',
            'cedula' => 'nullable|string|max:50',
            'vinculacion' => 'nullable|string|max:255',
            'fecha_registro' => 'nullable|date',
            'usuario_registra' => 'nullable|string|max:255',
        ]);

        $item = BiotecnologiaSiembraEquipo::findOrFail($id);
        $item->update($request->all());

        return redirect()->route('biotecnologia.siembra_equipos.index')
                         ->with('success', 'Equipo de siembra actualizado correctamente.');
    }

    public function destroy($id)
    {
        $item = BiotecnologiaSiembraEquipo::findOrFail($id);
        $item->delete();

        return redirect()->route('biotecnologia.siembra_equipos.index')
                         ->with('success', 'Equipo de siembra eliminado correctamente.');
    }

    public function exportPdf(Request $request)
    {
        $items = $this->filteredQuery($request)
            ->orderBy('nombre')
            ->get();

        $pdf = Pdf::loadView('exports.biotecnologia.siembra_equipos', [
            'items' => $items,
            'generatedAt' => now(),
        ])->setPaper('A4', 'landscape');

        return $pdf->download('biotecnologia_siembra_equipos_' . now()->format('Y-m-d_His') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $items = $this->filteredQuery($request)
            ->orderBy('nombre')
            ->get();

        return Excel::download(
            new BiotecnologiaSiembraEquiposExport($items),
            'biotecnologia_siembra_equipos_' . now()->format('Y-m-d_His') . '.xlsx'
        );
    }
private function getCatalogos()
{
    // -------------------------------
    // 1. RESPONSABLES POR DEFECTO (LISTA MAESTRA)
    // -------------------------------
    $defaultResponsables = collect([
        ['nombre_responsable' => 'Alcy Rene Ceron', 'cedula' => '76316028'],
        ['nombre_responsable' => 'Carolina Avila Cubillos', 'cedula' => '28551046'],
        ['nombre_responsable' => 'Eduardo Pastrana Granado', 'cedula' => '7719513'],
        ['nombre_responsable' => 'Kathryn Yadira Pacheco Guzman', 'cedula' => '38142927'],
        ['nombre_responsable' => 'Maria Goretti Ramirez', 'cedula' => '52962110'],
        ['nombre_responsable' => 'Sonia Carolina Delgado Murcia', 'cedula' => '1083883606'],
        ['nombre_responsable' => 'Yoly Dayana Moreno Ortega', 'cedula' => '34327134'],
    ])->map(fn ($item) => [
        'nombre' => trim($item['nombre_responsable']),
        'cedula' => trim($item['cedula']),
    ]);

    // Extraer cédulas de defaults para filtrar después
    $cedulasDefaults = $defaultResponsables->pluck('cedula')->toArray();

    // -------------------------------
    // 2. DATOS DESDE LA BD
    // -------------------------------
    $equipos = BiotecnologiaSiembraEquipo::select(
        'nombre_responsable',
        'cedula',
        'vinculacion',
        'usuario_registra'
    )->get();

    $inventario = Inventario::select(
        'nombre_responsable',
        'cedula',
        'vinculacion',
        'usuario_registra'
    )->get();

    // Combinar ambas fuentes
    $merged = $equipos->concat($inventario);

    // -------------------------------
    // 3. RESPONSABLES DE BD (EXCLUYENDO DEFAULTS Y CEDULAS DE PRUEBA)
    // -------------------------------
    $responsablesDb = $merged
        ->filter(function ($item) use ($cedulasDefaults) {
            $cedulaLimpia = trim($item->cedula ?? '');
            $nombreLimpio = trim($item->nombre_responsable ?? '');
            
            return !empty($nombreLimpio)
                && !empty($cedulaLimpia)
                && !in_array($cedulaLimpia, $cedulasDefaults)  // ✅ Excluir defaults
                && !str_contains($cedulaLimpia, '123456')       // ✅ Excluir cédulas de prueba
                && !str_contains($cedulaLimpia, '0987654');
        })
        ->map(fn ($item) => [
            'nombre' => trim($item->nombre_responsable),
            'cedula' => trim($item->cedula),
        ])
        ->unique('cedula');  // ✅ Eliminar duplicados por cédula

    // -------------------------------
    // 4. RESPONSABLES FINALES (DEFAULTS + ADICIONALES DE BD)
    // -------------------------------
    $responsables = $defaultResponsables
        ->concat($responsablesDb)
        ->sortBy('nombre')
        ->values();

    // -------------------------------
    // 5. VINCULACIONES
    // -------------------------------
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

    $vinculaciones = $defaultVinculaciones
        ->concat($vinculacionesDb)
        ->unique()
        ->sort()
        ->values();

    // -------------------------------
    // 6. CEDULAS Y USUARIOS UNICOS
    // -------------------------------
    $pluckUnique = fn ($field) => $merged
        ->pluck($field)
        ->filter()
        ->map(fn($v) => is_string($v) ? trim($v) : $v)
        ->unique()
        ->sort()
        ->values();

    // -------------------------------
    // 7. RETORNO FINAL
    // -------------------------------
    return [
        'responsables' => $responsables,
        'cedulas' => $pluckUnique('cedula'),
        'vinculaciones' => $vinculaciones,
        'usuarios' => $pluckUnique('usuario_registra'),
    ];
}

    protected function filteredQuery(Request $request)
    {
        return BiotecnologiaSiembraEquipo::query()
            ->when($request->filled('buscar'), function ($query) use ($request) {
                $buscar = $request->buscar;
                $query->where(function ($q) use ($buscar) {
                    $q->where('nombre', 'like', "%{$buscar}%")
                        ->orWhere('no_placa', 'like', "%{$buscar}%")
                        ->orWhere('nombre_responsable', 'like', "%{$buscar}%");
                });
            });
    }
}


