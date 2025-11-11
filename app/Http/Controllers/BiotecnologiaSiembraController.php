<?php

namespace App\Http\Controllers;

use App\Models\BiotecnologiaSiembra;
use Illuminate\Http\Request;

class BiotecnologiaSiembraController extends Controller
{
         public function index(Request $request)
{
    $buscar = $request->input('buscar');

    $items = \App\Models\BiotecnologiaSiembra::query()
        ->when($buscar, function ($query, $buscar) {
            $query->where('nombre_item', 'like', "%{$buscar}%")
                  ->orWhere('detalle', 'like', "%{$buscar}%");
        })
        ->orderBy('id', 'desc')
        ->paginate(10) // 👈 Muestra solo 10 por página
        ->withQueryString(); // 👈 Mantiene el valor del filtro al cambiar de página

    return view('labs.biotecnologia.siembra.index', compact('items', 'buscar'));
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

    // Formulario de edición en página (alternativo al modal)
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
}


