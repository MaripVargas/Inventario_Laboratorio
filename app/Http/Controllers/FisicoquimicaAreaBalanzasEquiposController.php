<?php

namespace App\Http\Controllers;

use App\Exports\FisicoquimicaAreaBalanzasEquiposExport;
use App\Models\FisicoquimicaAreaBalanzasEquipo;
use App\Models\Inventario;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class FisicoquimicaAreaBalanzasEquiposController extends Controller
{
    public function index(Request $request)
    {
        $items = $this->filteredQuery($request)
            ->orderByDesc('id')
            ->get();

        return view('labs.fisicoquimica.area_balanzas_equipos.index', compact('items'));
    }

    public function create()
    {
        $catalogos = $this->getCatalogos();
        return view('labs.fisicoquimica.area_balanzas_equipos.create', compact('catalogos'));
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

        FisicoquimicaAreaBalanzasEquipo::create($request->all());

        return redirect()->route('fisicoquimica.area_balanzas_equipos.index')
                         ->with('success', 'Equipo agregado correctamente.');
    }

    public function edit($id)
    {
        $item = FisicoquimicaAreaBalanzasEquipo::findOrFail($id);
        $catalogos = $this->getCatalogos();
        return view('labs.fisicoquimica.area_balanzas_equipos.edit', compact('item', 'catalogos'));
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

        $item = FisicoquimicaAreaBalanzasEquipo::findOrFail($id);
        $item->update($request->all());

        return redirect()->route('fisicoquimica.area_balanzas_equipos.index')
                         ->with('success', 'Equipo actualizado correctamente.');
    }

    public function destroy($id)
    {
        $item = FisicoquimicaAreaBalanzasEquipo::findOrFail($id);
        $item->delete();

        return redirect()->route('fisicoquimica.area_balanzas_equipos.index')
                         ->with('success', 'Equipo eliminado correctamente.');
    }

    public function exportPdf(Request $request)
    {
        $items = $this->filteredQuery($request)
            ->orderBy('nombre')
            ->get();

        $pdf = Pdf::loadView('exports.fisicoquimica.area_balanzas_equipos', [
            'items' => $items,
            'generatedAt' => now(),
        ])->setPaper('A4', 'landscape');

        return $pdf->download('fisicoquimica_area_balanzas_equipos_' . now()->format('Y-m-d_His') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $items = $this->filteredQuery($request)
            ->orderBy('nombre')
            ->get();

        return Excel::download(
            new FisicoquimicaAreaBalanzasEquiposExport($items),
            'fisicoquimica_area_balanzas_equipos_' . now()->format('Y-m-d_His') . '.xlsx'
        );
    }

    private function getCatalogos()
    {
        $defaultResponsables = collect([
            ['nombre_responsable' => 'Carolina Avila Cubillos', 'cedula' => '28551046'],
            ['nombre_responsable' => 'Maria Goretti Ramirez', 'cedula' => '52962110'],
            ['nombre_responsable' => 'Alcy Rene Ceron', 'cedula' => '76316028'],
            ['nombre_responsable' => 'Yoly Dayana Moreno Ortega', 'cedula' => '34327134'],
            ['nombre_responsable' => 'Kathryn Yadira Pacheco Guzman', 'cedula' => '38142927'],
            ['nombre_responsable' => ' Eduardo Pastrana Granado ', 'cedula' => '7719513'],
            ['nombre_responsable' => 'Sonia Carolina Delgado Murcia', 'cedula' => '1083883606'],
        ]);

        $equipos = FisicoquimicaAreaBalanzasEquipo::select(
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

        $responsablesDb = $merged
            ->filter(fn ($item) => !empty($item->nombre_responsable))
            ->map(fn ($item) => [
                'nombre' => $item->nombre_responsable,
                'cedula' => $item->cedula,
            ]);

        $responsables = $defaultResponsables
            ->map(fn ($item) => [
                'nombre' => $item['nombre_responsable'],
                'cedula' => $item['cedula'],
            ])
            ->concat($responsablesDb)
            ->unique(fn ($item) => $item['nombre'] . '|' . ($item['cedula'] ?? ''))
            ->sortBy('nombre')
            ->values();

        $defaultVinculaciones = collect([
            'Funcionario Administrativo',
            'Contrato',
            'Provisional'
        ]);

        $vinculacionesDb = $merged
            ->pluck('vinculacion')
            ->filter()
            ->unique();

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
        return FisicoquimicaAreaBalanzasEquipo::query()
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
