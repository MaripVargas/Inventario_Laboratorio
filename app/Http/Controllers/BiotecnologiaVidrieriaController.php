<?php

namespace App\Http\Controllers;

use App\Models\BiotecnologiaVidrieria;
use Illuminate\Http\Request;

class BiotecnologiaVidrieriaController extends Controller
{
    public function index(Request $request)
{
    $buscar = $request->input('buscar');

    $items = \App\Models\BiotecnologiaVidrieria::query()
        ->when($buscar, function ($query, $buscar) {
            $query->where('nombre_item', 'like', "%{$buscar}%")
                  ->orWhere('detalle', 'like', "%{$buscar}%");
        })
        ->orderBy('id', 'desc')
        ->paginate(10) // 👈 Muestra solo 10 por página
        ->withQueryString(); // 👈 Mantiene el valor del filtro al cambiar de página

    return view('labs.biotecnologia.vidrieria.index', compact('items', 'buscar'));
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
}
