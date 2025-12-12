<?php

namespace App\Http\Controllers;

use App\Exports\FisicoquimicaLaboratorioAnalisisEquiposExport;
use App\Models\FisicoquimicaLaboratorioAnalisisEquipo;
use App\Models\Inventario;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class FisicoquimicaLaboratorioAnalisisEquiposController extends Controller
{
    public function index(Request $request)
    {
        $items = $this->filteredQuery($request)
            ->orderByDesc('id')
            ->get();

        return view('labs.fisicoquimica.laboratorio_analisis_equipos.index', compact('items'));
    }

    public function create()
    {
        $catalogos = $this->getCatalogos();
        return view('labs.fisicoquimica.laboratorio_analisis_equipos.create', compact('catalogos'));
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

        FisicoquimicaLaboratorioAnalisisEquipo::create($request->all());

        return redirect()->route('fisicoquimica.laboratorio_analisis_equipos.index')
                         ->with('success', 'Equipo agregado correctamente.');
    }

    public function edit($id)
    {
        $item = FisicoquimicaLaboratorioAnalisisEquipo::findOrFail($id);
        $catalogos = $this->getCatalogos();
        return view('labs.fisicoquimica.laboratorio_analisis_equipos.edit', compact('item', 'catalogos'));
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

        $item = FisicoquimicaLaboratorioAnalisisEquipo::findOrFail($id);
        $item->update($request->all());

        return redirect()->route('fisicoquimica.laboratorio_analisis_equipos.index')
                         ->with('success', 'Equipo actualizado correctamente.');
    }

    public function destroy($id)
    {
        $item = FisicoquimicaLaboratorioAnalisisEquipo::findOrFail($id);
        $item->delete();

        return redirect()->route('fisicoquimica.laboratorio_analisis_equipos.index')
                         ->with('success', 'Equipo eliminado correctamente.');
    }

    public function exportPdf(Request $request)
    {
        $items = $this->filteredQuery($request)
            ->orderBy('nombre')
            ->get();

        $pdf = Pdf::loadView('exports.fisicoquimica.laboratorio_analisis_equipos', [
            'items' => $items,
            'generatedAt' => now(),
        ])->setPaper('A4', 'landscape');

        return $pdf->download('fisicoquimica_laboratorio_analisis_equipos_' . now()->format('Y-m-d_His') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $items = $this->filteredQuery($request)
            ->orderBy('nombre')
            ->get();

        return Excel::download(
            new FisicoquimicaLaboratorioAnalisisEquiposExport($items),
            'fisicoquimica_laboratorio_analisis_equipos_' . now()->format('Y-m-d_His') . '.xlsx'
        );
    }

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

    // 3. Obtener datos de equipos e inventario
    $equipos = FisicoquimicaLaboratorioAnalisisEquipo::select(
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

    $merged = $equipos->concat($inventario);

    // 4. Responsables de BD (excluyendo defaults y cédulas de prueba)
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

    // 5. Combinar: defaults primero + adicionales de BD
    $responsables = $defaultResponsables
        ->concat($responsablesDb)
        ->sortBy('nombre')
        ->values();

    // 6. Vinculaciones
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

    // 7. Helper para extraer valores únicos
    $pluckUnique = fn ($field) => $merged
        ->pluck($field)
        ->filter()
        ->map(fn($v) => is_string($v) ? trim($v) : $v)
        ->unique()
        ->sort()
        ->values();

    return [
        'responsables' => $responsables,
        'cedulas' => $pluckUnique('cedula'),
        'vinculaciones' => $vinculaciones,
        'usuarios' => $pluckUnique('usuario_registra'),
    ];
}

    protected function filteredQuery(Request $request)
    {
        return FisicoquimicaLaboratorioAnalisisEquipo::query()
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
