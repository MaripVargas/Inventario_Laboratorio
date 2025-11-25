<?php

namespace App\Http\Controllers;

use App\Exports\BiotecnologiaVidrieriaExport;
use App\Models\BiotecnologiaVidrieria;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BiotecnologiaVidrieriaController extends Controller
{
    public function index(Request $request)
    {
        $items = $this->filteredQuery($request)
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('labs.biotecnologia.vidrieria.index', [
            'items' => $items,
            'buscar' => $request->input('buscar'),
        ]);
    }

    public function create()
    {
        return view('labs.biotecnologia.vidrieria.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_item' => 'required|string|max:255',
            'volumen' => 'nullable|string|max:100',
            'cantidad' => 'nullable|integer',
            'unidad' => 'nullable|string|max:100',
            'detalle' => 'nullable|string|max:500',
        ]);

        BiotecnologiaVidrieria::create($request->all());

        return redirect()->route('biotecnologia.vidrieria.index')
                         ->with('success', 'Material agregado correctamente.');
    }

    public function edit($id)
    {
        try {
            $item = BiotecnologiaVidrieria::findOrFail($id);

            return response()->json([
                'id' => $item->id,
                'nombre_item' => $item->nombre_item,
                'volumen' => $item->volumen,
                'cantidad' => $item->cantidad,
                'unidad' => $item->unidad,
                'detalle' => $item->detalle,
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Material no encontrado'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error interno', 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_item' => 'required|string|max:255',
            'volumen' => 'nullable|string|max:100',
            'cantidad' => 'nullable|integer',
            'unidad' => 'nullable|string|max:100',
            'detalle' => 'nullable|string|max:500',
        ]);

        $item = BiotecnologiaVidrieria::findOrFail($id);
        $item->update($request->all());

        return redirect()->route('biotecnologia.vidrieria.index')
                         ->with('success', 'Material actualizado correctamente.');
    }

    public function destroy($id)
    {
        $item = BiotecnologiaVidrieria::findOrFail($id);
        $item->delete();

        return redirect()->route('biotecnologia.vidrieria.index')
                         ->with('success', 'Material eliminado correctamente.');
    }

    public function exportPdf(Request $request)
    {
        $items = $this->filteredQuery($request)
            ->orderBy('nombre_item')
            ->get();

        $pdf = Pdf::loadView('exports.biotecnologia.vidrieria', [
            'items' => $items,
            'generatedAt' => now(),
        ])->setPaper('A4', 'landscape');

        return $pdf->download('biotecnologia_vidrieria_' . now()->format('Y-m-d_His') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $items = $this->filteredQuery($request)
            ->orderBy('nombre_item')
            ->get();

        return Excel::download(
            new BiotecnologiaVidrieriaExport($items),
            'biotecnologia_vidrieria_' . now()->format('Y-m-d_His') . '.xlsx'
        );
    }

    protected function filteredQuery(Request $request)
    {
        return BiotecnologiaVidrieria::query()
            ->when($request->filled('buscar'), function ($query) use ($request) {
                $buscar = $request->input('buscar');
                $query->where(function ($inner) use ($buscar) {
                    $inner->where('nombre_item', 'like', "%{$buscar}%")
                        ->orWhere('detalle', 'like', "%{$buscar}%")
                        ->orWhere('volumen', 'like', "%{$buscar}%");
                });
            });
    }
}
