<?php

namespace App\Http\Controllers;

use App\Exports\FisicoquimicaSecadoSuelosExport;
use App\Models\FisicoquimicaSecadoSuelos;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class FisicoquimicaSecadoSuelosController extends Controller
{
    public function index(Request $request)
    {
        $items = $this->filteredQuery($request)
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('labs.fisicoquimica.secado_suelos.index', compact('items'));
    }

    public function create()
    {
        return view('labs.fisicoquimica.secado_suelos.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre_item' => 'required|string|max:255',
            'cantidad' => 'nullable|integer',
            'unidad' => 'nullable|string|max:100',
            'detalle' => 'nullable|string|max:500',
        ]);

        FisicoquimicaSecadoSuelos::create($data);

        return redirect()->route('fisicoquimica.secado_suelos.index')
            ->with('success', 'Artículo agregado correctamente.');
    }

    public function edit($id)
    {
        try {
            $item = FisicoquimicaSecadoSuelos::findOrFail($id);

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

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_item' => 'required|string|max:255',
            'cantidad' => 'nullable|integer',
            'unidad' => 'nullable|string|max:100',
            'detalle' => 'nullable|string|max:500',
        ]);

        $item = FisicoquimicaSecadoSuelos::findOrFail($id);
        $item->update($request->all());

        return redirect()->route('fisicoquimica.secado_suelos.index')
            ->with('success', 'Artículo actualizado correctamente.');
    }

    public function destroy($id)
    {
        FisicoquimicaSecadoSuelos::findOrFail($id)->delete();

        return redirect()->route('fisicoquimica.secado_suelos.index')
            ->with('success', 'Artículo eliminado correctamente.');
    }

    public function exportPdf(Request $request)
    {
        $items = $this->filteredQuery($request)
            ->orderBy('nombre_item')
            ->get();

        $pdf = Pdf::loadView('exports.fisicoquimica.secado_suelos', [
            'items' => $items,
            'generatedAt' => now(),
        ])->setPaper('A4', 'landscape');

        return $pdf->download('fisicoquimica_secado_suelos_' . now()->format('Y-m-d_His') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $items = $this->filteredQuery($request)
            ->orderBy('nombre_item')
            ->get();

        return Excel::download(
            new FisicoquimicaSecadoSuelosExport($items),
            'fisicoquimica_secado_suelos_' . now()->format('Y-m-d_His') . '.xlsx'
        );
    }

    protected function filteredQuery(Request $request)
    {
        return FisicoquimicaSecadoSuelos::query()
            ->when($request->filled('buscar'), function ($query) use ($request) {
                $buscar = $request->input('buscar');
                $query->where(function ($inner) use ($buscar) {
                    $inner->where('nombre_item', 'like', "%{$buscar}%")
                        ->orWhere('detalle', 'like', "%{$buscar}%");
                });
            });
    }
}


