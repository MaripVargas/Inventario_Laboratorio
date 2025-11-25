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
        // Responsables por defecto (catálogo base)
        $defaultResponsables = collect([
            ['nombre_responsable' => 'Carolina Avila', 'cedula' => '28551046'],
            ['nombre_responsable' => 'Maria Goretti Ramirez', 'cedula' => '52962110'],
            ['nombre_responsable' => 'Alcy Rene Ceron', 'cedula' => '76316028'],
            ['nombre_responsable' => 'Yoli Dayana Moreno', 'cedula' => '34327134'],
            ['nombre_responsable' => 'Kathryn Yadira Pacheco Guzman', 'cedula' => '38142927'],
            ['nombre_responsable' => 'Pastrana Granados Eduardo', 'cedula' => '7719513'],
        ]);

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

        // Combinar y asegurar unicidad - TODOS SON ARRAYS AHORA
        $merged = $equipos->concat($inventario);

        $responsablesDb = $merged
            ->filter(fn ($item) => !empty($item->nombre_responsable))
            ->map(fn ($item) => [
                'nombre' => $item->nombre_responsable,
                'cedula' => $item->cedula,
            ]);

        // Combinar responsables por defecto con los de la BD
        $responsables = $defaultResponsables
            ->map(fn ($item) => [
                'nombre' => $item['nombre_responsable'],
                'cedula' => $item['cedula'],
            ])
            ->concat($responsablesDb)
            ->unique(fn ($item) => $item['nombre'] . '|' . ($item['cedula'] ?? ''))
            ->sortBy('nombre')
            ->values();

        // Vinculaciones por defecto
        $defaultVinculaciones = collect([
            'Funcionario Administrativo',
            'Contrato',
            'Provisional'
        ]);

        $vinculacionesDb = $merged
            ->pluck('vinculacion')
            ->filter()
            ->unique();

        // Combinar vinculaciones por defecto con las de la BD
        $vinculaciones = $defaultVinculaciones
            ->concat($vinculacionesDb)
            ->unique()
            ->sort()
            ->values();

        $pluckUnique = fn ($field) => $merged
            ->pluck($field)
            ->filter()
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


