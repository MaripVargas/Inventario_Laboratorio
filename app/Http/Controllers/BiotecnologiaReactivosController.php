<?php

namespace App\Http\Controllers;

use App\Exports\BiotecnologiaReactivosExport;
use App\Models\BiotecnologiaReactivos;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BiotecnologiaReactivosController extends Controller
{
    public function index(Request $request)
    {
        $items = $this->filteredQuery($request)
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('labs.biotecnologia.reactivos.index', [
            'items' => $items,
            'buscar' => $request->input('buscar'),
        ]);
    }

    public function create()
    {
        return view('labs.biotecnologia.reactivos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_reactivo' => 'required|string|max:255',
            'cantidad' => 'nullable|integer',
            'unidad' => 'nullable|string|max:100',
            'concentracion' => 'nullable|string|max:100',
            'detalle' => 'nullable|string|max:500',
        ]);

        BiotecnologiaReactivos::create($request->all());

        return redirect()->route('biotecnologia.reactivos.index')
                         ->with('success', 'Reactivo agregado correctamente.');
    }

    public function edit($id)
    {
        try {
            $item = BiotecnologiaReactivos::findOrFail($id);

            return response()->json([
                'id' => $item->id,
                'nombre_reactivo' => $item->nombre_reactivo,
                'cantidad' => $item->cantidad,
                'unidad' => $item->unidad,
                'concentracion' => $item->concentracion,
                'detalle' => $item->detalle,
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Reactivo no encontrado'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error interno', 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_reactivo' => 'required|string|max:255',
            'cantidad' => 'nullable|integer',
            'unidad' => 'nullable|string|max:100',
            'concentracion' => 'nullable|string|max:100',
            'detalle' => 'nullable|string|max:500',
        ]);

        $reactivo = BiotecnologiaReactivos::findOrFail($id);
        $reactivo->update($request->all());

        return redirect()->route('biotecnologia.reactivos.index')
                         ->with('success', 'Reactivo actualizado correctamente.');
    }

    public function destroy($id)
    {
        $reactivo = BiotecnologiaReactivos::findOrFail($id);
        $reactivo->delete();

        return redirect()->route('biotecnologia.reactivos.index')
                         ->with('success', 'Reactivo eliminado correctamente.');
    }

    public function exportPdf(Request $request)
    {
        $items = $this->filteredQuery($request)
            ->orderBy('nombre_reactivo')
            ->get();

        $pdf = Pdf::loadView('exports.biotecnologia.reactivos', [
            'items' => $items,
            'generatedAt' => now(),
        ])->setPaper('A4', 'landscape');

        return $pdf->download('biotecnologia_reactivos_' . now()->format('Y-m-d_His') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $items = $this->filteredQuery($request)
            ->orderBy('nombre_reactivo')
            ->get();

        return Excel::download(
            new BiotecnologiaReactivosExport($items),
            'biotecnologia_reactivos_' . now()->format('Y-m-d_His') . '.xlsx'
        );
    }

    protected function filteredQuery(Request $request)
    {
        return BiotecnologiaReactivos::query()
            ->when($request->filled('buscar'), function ($query) use ($request) {
                $buscar = $request->input('buscar');
                $query->where(function ($inner) use ($buscar) {
                    $inner->where('nombre_reactivo', 'like', "%{$buscar}%")
                        ->orWhere('detalle', 'like', "%{$buscar}%")
                        ->orWhere('concentracion', 'like', "%{$buscar}%");
                });
            });
    }
}
