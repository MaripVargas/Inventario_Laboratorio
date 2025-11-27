<?php

namespace App\Http\Controllers;

use App\Exports\ZoologiaUtileriaExport;
use App\Models\ZoologiaUtileria;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ZoologiaUtileriaController extends Controller
{
    /**
     * Mostrar todos los registros
     */
     public function index(Request $request)
{
    $items = $this->filteredQuery($request)
        ->orderBy('id', 'desc')
        ->paginate(10)
        ->withQueryString();

    $buscar = $request->input('buscar');

    return view('labs.zoologia.utileria.index', compact('items', 'buscar'));
}


    /**
     * Mostrar formulario para crear nuevo registro
     */
    public function create()
    {
        return view('labs.zoologia.utileria.create');
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

        ZoologiaUtileria::create($request->all());

        return redirect()->route('zoologia.utileria.index')
                         ->with('success', 'Artículo agregado correctamente.');
    }

    /**
     * Mostrar formulario de edición
     */
public function edit($id)
{
    try {
        $item = ZoologiaUtileria::findOrFail($id); // <--- Cambiado Item por BiotecnologiaUtileria

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

        $item = ZoologiaUtileria::findOrFail($id);
        $item->update($request->all());

        return redirect()->route('zoologia.utileria.index')
                         ->with('success', 'Artículo actualizado correctamente.');
    }

    /**
     * Eliminar un registro
     */
    public function destroy($id)
    {
        $item = ZoologiaUtileria::findOrFail($id);
        $item->delete();

        return redirect()->route('zoologia.utileria.index')
                         ->with('success', 'Artículo eliminado correctamente.');
    }

    public function exportPdf(Request $request)
    {
        $items = $this->filteredQuery($request)
            ->orderBy('nombre_item')
            ->get();

        $pdf = Pdf::loadView('exports.zoologia.utileria', [
            'items' => $items,
            'generatedAt' => now(),
        ])->setPaper('A4', 'landscape');

        return $pdf->download('zoologia_utileria_' . now()->format('Y-m-d_His') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $items = $this->filteredQuery($request)
            ->orderBy('nombre_item')
            ->get();

        return Excel::download(
            new ZoologiaUtileriaExport($items),
            'zoologia_utileria_' . now()->format('Y-m-d_His') . '.xlsx'
        );
    }

    protected function filteredQuery(Request $request)
    {
        return ZoologiaUtileria::query()
            ->when($request->filled('buscar'), function ($query) use ($request) {
                $buscar = $request->input('buscar');
                $query->where(function ($inner) use ($buscar) {
                    $inner->where('nombre_item', 'like', "%{$buscar}%")
                        ->orWhere('detalle', 'like', "%{$buscar}%");
                });
            });
    }
}
