<?php

namespace App\Http\Controllers;

use App\Exports\BiotecnologiaSiembraExport;
use App\Models\BiotecnologiaSiembra;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BiotecnologiaSiembraController extends Controller
{
    public function index(Request $request)
    {
        $items = $this->filteredQuery($request)
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('labs.biotecnologia.siembra.index', [
            'items' => $items,
            'buscar' => $request->input('buscar'),
        ]);
    }

    public function create()
    {
        return view('labs.biotecnologia.siembra.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_siembra' => 'required|string|max:255',
            'cantidad' => 'nullable|integer',
            'unidad' => 'nullable|string|max:100',
            'detalle' => 'nullable|string|max:500',
        ]);

        BiotecnologiaSiembra::create($request->all());

        return redirect()->route('biotecnologia.siembra.index')
                         ->with('success', 'Siembra agregada correctamente.');
    }

    public function edit($id)
    {
        $item = BiotecnologiaSiembra::findOrFail($id);

        return response()->json([
            'id' => $item->id,
            'nombre_siembra' => $item->nombre_siembra,
            'cantidad' => $item->cantidad,
            'unidad' => $item->unidad,
            'detalle' => $item->detalle,
        ]);
    }

    public function editForm($id)
    {
        $item = BiotecnologiaSiembra::findOrFail($id);

        return view('labs.biotecnologia.siembra.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_siembra' => 'required|string|max:255',
            'cantidad' => 'nullable|integer',
            'unidad' => 'nullable|string|max:100',
            'detalle' => 'nullable|string|max:500',
        ]);

        $item = BiotecnologiaSiembra::findOrFail($id);
        $item->update($request->all());

        return redirect()->route('biotecnologia.siembra.index')
                         ->with('success', 'Siembra actualizada correctamente.');
    }

    public function destroy($id)
    {
        $item = BiotecnologiaSiembra::findOrFail($id);
        $item->delete();

        return redirect()->route('biotecnologia.siembra.index')
                         ->with('success', 'Siembra eliminada correctamente.');
    }

    public function exportPdf(Request $request)
    {
        $items = $this->filteredQuery($request)
            ->orderBy('nombre_siembra')
            ->get();

        $pdf = Pdf::loadView('exports.biotecnologia.siembra', [
            'items' => $items,
            'generatedAt' => now(),
        ])->setPaper('A4', 'landscape');

        return $pdf->download('biotecnologia_siembra_' . now()->format('Y-m-d_His') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $items = $this->filteredQuery($request)
            ->orderBy('nombre_siembra')
            ->get();

        return Excel::download(
            new BiotecnologiaSiembraExport($items),
            'biotecnologia_siembra_' . now()->format('Y-m-d_His') . '.xlsx'
        );
    }

    protected function filteredQuery(Request $request)
    {
        return BiotecnologiaSiembra::query()
            ->when($request->filled('buscar'), function ($query) use ($request) {
                $buscar = $request->input('buscar');
                $query->where(function ($inner) use ($buscar) {
                    $inner->where('nombre_siembra', 'like', "%{$buscar}%")
                        ->orWhere('detalle', 'like', "%{$buscar}%");
                });
            });
    }
}
