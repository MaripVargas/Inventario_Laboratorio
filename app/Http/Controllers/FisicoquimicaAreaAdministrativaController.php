<?php

namespace App\Http\Controllers;

use App\Exports\FisicoquimicaAreaAdministrativaExport;
use App\Models\FisicoquimicaAreaAdministrativa;
use App\Models\Inventario;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class FisicoquimicaAreaAdministrativaController extends Controller
{
    public function index(Request $request)
    {
        $items = $this->filteredQuery($request)
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('labs.fisicoquimica.area_administrativa.index', compact('items'));
    }

    public function create()
    {
        $catalogos = $this->getCatalogos();
        return view('labs.fisicoquimica.area_administrativa.create', compact('catalogos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre_item' => 'required|string|max:255',
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

        FisicoquimicaAreaAdministrativa::create($data);

        return redirect()->route('fisicoquimica.area_administrativa.index')
            ->with('success', 'Artículo agregado correctamente.');
    }

    public function edit($id)
    {
        try {
            $item = FisicoquimicaAreaAdministrativa::findOrFail($id);

            return response()->json([
                'id' => $item->id,
                'nombre_item' => $item->nombre_item,
                'cantidad' => $item->cantidad,
                'unidad' => $item->unidad,
                'detalle' => $item->detalle,
                'no_placa' => $item->no_placa,
                'fecha_adq' => $item->fecha_adq?->format('Y-m-d'),
                'valor' => $item->valor,
                'nombre_responsable' => $item->nombre_responsable,
                'cedula' => $item->cedula,
                'vinculacion' => $item->vinculacion,
                'fecha_registro' => $item->fecha_registro?->format('Y-m-d'),
                'usuario_registra' => $item->usuario_registra,
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Artículo no encontrado'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error interno', 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_item' => 'required|string|max:255',
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

        $item = FisicoquimicaAreaAdministrativa::findOrFail($id);
        $item->update($request->all());

        return redirect()->route('fisicoquimica.area_administrativa.index')
            ->with('success', 'Artículo actualizado correctamente.');
    }

    public function destroy($id)
    {
        FisicoquimicaAreaAdministrativa::findOrFail($id)->delete();

        return redirect()->route('fisicoquimica.area_administrativa.index')
            ->with('success', 'Artículo eliminado correctamente.');
    }

    public function exportPdf(Request $request)
    {
        $items = $this->filteredQuery($request)
            ->orderBy('nombre_item')
            ->get();

        $pdf = Pdf::loadView('exports.fisicoquimica.area_administrativa', [
            'items' => $items,
            'generatedAt' => now(),
        ])->setPaper('A4', 'landscape');

        return $pdf->download('fisicoquimica_area_administrativa_' . now()->format('Y-m-d_His') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $items = $this->filteredQuery($request)
            ->orderBy('nombre_item')
            ->get();

        return Excel::download(
            new FisicoquimicaAreaAdministrativaExport($items),
            'fisicoquimica_area_administrativa_' . now()->format('Y-m-d_His') . '.xlsx'
        );
    }

    protected function filteredQuery(Request $request)
    {
        return FisicoquimicaAreaAdministrativa::query()
            ->when($request->filled('buscar'), function ($query) use ($request) {
                $buscar = $request->input('buscar');
                $query->where(function ($inner) use ($buscar) {
                    $inner->where('nombre_item', 'like', "%{$buscar}%")
                        ->orWhere('detalle', 'like', "%{$buscar}%")
                        ->orWhere('no_placa', 'like', "%{$buscar}%")
                        ->orWhere('nombre_responsable', 'like', "%{$buscar}%");
                });
            });
    }

    // ================================================================
    // 🔥 MÉTODO getCatalogos() SIN DUPLICADOS (VERSIÓN FINAL)
    // ================================================================
    private function getCatalogos()
    {
        // Normalizador
        $normalize = function ($value) {
            if (!$value) return '';
            $value = trim($value);
            $value = preg_replace('/\s+/', ' ', $value);
            return mb_strtolower($value);
        };

        // Default
        $defaultResponsables = collect([
            ['nombre' => 'Carolina Avila Cubillos', 'cedula' => '28551046'],
            ['nombre' => 'Maria Goretti Ramirez', 'cedula' => '52962110'],
            ['nombre' => 'Alcy Rene Ceron', 'cedula' => '76316028'],
            ['nombre' => 'Yoly Dayana Moreno Ortega', 'cedula' => '34327134'],
            ['nombre' => 'Kathryn Yadira Pacheco Guzman', 'cedula' => '38142927'],
            ['nombre' => 'Eduardo Pastrana Granado', 'cedula' => '7719513'],
            ['nombre' => 'Sonia Carolina Delgado Murcia', 'cedula' => '1083883606'],
        ])->map(function ($item) use ($normalize) {
            return [
                'nombre' => trim(preg_replace('/\s+/', ' ', $item['nombre'])),
                'cedula' => trim($item['cedula']),
                'key'    => $normalize($item['nombre']),
            ];
        });

        // BD
        $items = FisicoquimicaAreaAdministrativa::select(
            'nombre_responsable', 'cedula', 'vinculacion', 'usuario_registra'
        )->get();

        $inventario = Inventario::select(
            'nombre_responsable', 'cedula', 'vinculacion', 'usuario_registra'
        )->get();

        $merged = $items->concat($inventario);

        // Normalizar BD
        $responsablesDb = $merged
            ->filter(fn ($item) => !empty(trim($item->nombre_responsable)))
            ->map(function ($item) use ($normalize) {
                $nombre = trim(preg_replace('/\s+/', ' ', $item->nombre_responsable));
                return [
                    'nombre' => $nombre,
                    'cedula' => trim($item->cedula ?? ''),
                    'key'    => $normalize($nombre),
                ];
            });

        // Combinar + eliminar duplicados
        $responsables = $defaultResponsables
            ->concat($responsablesDb)
            ->unique('key')
            ->sortBy('nombre')
            ->values();

        // Vinculaciones
        $defaultVinculaciones = collect([
            'Funcionario Administrativo',
            'Contrato',
            'Planta'
        ]);

        $vinculaciones = $defaultVinculaciones
            ->concat($merged->pluck('vinculacion')->filter())
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
}

