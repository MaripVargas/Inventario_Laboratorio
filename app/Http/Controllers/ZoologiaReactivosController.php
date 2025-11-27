<?php

namespace App\Http\Controllers;

use App\Exports\ZoologiaReactivosExport;
use App\Models\ZoologiaReactivos;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ZoologiaReactivosController extends Controller
{
     public function index(Request $request)
{
    $items = $this->filteredQuery($request)
        ->orderBy('id', 'desc')
        ->paginate(10)
        ->withQueryString();

    $buscar = $request->input('buscar');

    return view('labs.zoologia.reactivos.index', compact('items', 'buscar'));
}


    public function create()
    {
        return view('labs.zoologia.reactivos.create');
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

        ZoologiaReactivos::create($request->all());

        return redirect()->route('zoologia.reactivos.index')
                         ->with('success', 'Reactivo agregado correctamente.');
    }
public function edit($id)
{
    try {
        $item = ZoologiaReactivos::findOrFail($id);

        // Devuelve la vista parcial con el formulario
        return view('labs.zoologia.reactivos.edit', compact('item'))->render();

    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al cargar el formulario'], 500);
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

        $reactivo = ZoologiaReactivos::findOrFail($id);
        $reactivo->update($request->all());

        return redirect()->route('zoologia.reactivos.index')
                         ->with('success', 'Reactivo actualizado correctamente.');
    }

    public function destroy($id)
    {
        $reactivo = ZoologiaReactivos::findOrFail($id);
        $reactivo->delete();

        return redirect()->route('zoologia.reactivos.index')
                         ->with('success', 'Reactivo eliminado correctamente.');
    }

    public function exportPdf(Request $request)
    {
        $items = $this->filteredQuery($request)
            ->orderBy('nombre_reactivo')
            ->get();

        $pdf = Pdf::loadView('exports.zoologia.reactivos', [
            'items' => $items,
            'generatedAt' => now(),
        ])->setPaper('A4', 'landscape');

        return $pdf->download('zoologia_reactivos_' . now()->format('Y-m-d_His') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $items = $this->filteredQuery($request)
            ->orderBy('nombre_reactivo')
            ->get();

        return Excel::download(
            new ZoologiaReactivosExport($items),
            'zoologia_reactivos_' . now()->format('Y-m-d_His') . '.xlsx'
        );
    }

    protected function filteredQuery(Request $request)
    {
        return ZoologiaReactivos::query()
            ->when($request->filled('buscar'), function ($query) use ($request) {
                $buscar = $request->input('buscar');
                $query->where(function ($inner) use ($buscar) {
                    $inner->where('nombre_reactivo', 'like', "%{$buscar}%")
                        ->orWhere('detalle', 'like', "%{$buscar}%");
                });
            });
    }
}
