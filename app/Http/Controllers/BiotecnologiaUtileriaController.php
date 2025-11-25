<?php

namespace App\Http\Controllers;

use App\Exports\BiotecnologiaUtileriaExport;
use App\Models\BiotecnologiaUtileria;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BiotecnologiaUtileriaController extends Controller
{
    /**
     * Mostrar todos los registros
     */
    public function index(Request $request)
    {
        $items = $this->filteredQuery($request)
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('labs.biotecnologia.utileria.index', [
            'items' => $items,
            'buscar' => $request->input('buscar'),
        ]);
    }

    /**
     * Mostrar formulario para crear nuevo registro
     */
    public function create()
    {
        return view('labs.biotecnologia.utileria.create');
    }

    /**
     * Guardar un nuevo registro
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_item' => 'required|string|max:255',
            'cantidad' => 'nullable|integer',
            'unidad' => 'nullable|string|max:100',
            'detalle' => 'nullable|string|max:500',
        ]);

        BiotecnologiaUtileria::create($request->all());

        return redirect()->route('biotecnologia.utileria.index')
                         ->with('success', 'Artículo agregado correctamente.');
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit($id)
    {
        try {
            $item = BiotecnologiaUtileria::findOrFail($id);

            return response()->json([
                'id' => $item->id,
                'nombre_item' => $item->nombre_item,
                'cantidad' => $item->cantidad,
                'unidad' => $item->unidad,
                'detalle' => $item->detalle,
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Artículo no encontrado'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error interno', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Actualizar un registro existente
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_item' => 'required|string|max:255',
            'cantidad' => 'nullable|integer',
            'unidad' => 'nullable|string|max:100',
            'detalle' => 'nullable|string|max:500',
        ]);

        $item = BiotecnologiaUtileria::findOrFail($id);
        $item->update($request->all());

        return redirect()->route('biotecnologia.utileria.index')
                         ->with('success', 'Artículo actualizado correctamente.');
    }

    /**
     * Eliminar un registro
     */
    public function destroy($id)
    {
        $item = BiotecnologiaUtileria::findOrFail($id);
        $item->delete();

        return redirect()->route('biotecnologia.utileria.index')
                         ->with('success', 'Artículo eliminado correctamente.');
    }

    /**
     * Exportar PDF con filtros aplicados
     */
    public function exportPdf(Request $request)
    {
        $items = $this->filteredQuery($request)
            ->orderBy('nombre_item')
            ->get();

        $pdf = Pdf::loadView('exports.biotecnologia.utileria', [
            'items' => $items,
            'generatedAt' => now(),
        ])->setPaper('A4', 'landscape');

        return $pdf->download('biotecnologia_utileria_' . now()->format('Y-m-d_His') . '.pdf');
    }

    /**
     * Exportar Excel con filtros aplicados
     */
    public function exportExcel(Request $request)
    {
        $items = $this->filteredQuery($request)
            ->orderBy('nombre_item')
            ->get();

        return Excel::download(
            new BiotecnologiaUtileriaExport($items),
            'biotecnologia_utileria_' . now()->format('Y-m-d_His') . '.xlsx'
        );
    }

    /**
     * Construye el query respetando los filtros de la vista
     */
    protected function filteredQuery(Request $request)
    {
        return BiotecnologiaUtileria::query()
            ->when($request->filled('buscar'), function ($query) use ($request) {
                $buscar = $request->input('buscar');
                $query->where(function ($inner) use ($buscar) {
                    $inner->where('nombre_item', 'like', "%{$buscar}%")
                        ->orWhere('detalle', 'like', "%{$buscar}%");
                });
            });
    }
}
