<?php

namespace App\Http\Controllers;

use App\Models\BiotecnologiaReactivos;
use Illuminate\Http\Request;

class BiotecnologiaReactivosController extends Controller
{
     public function index(Request $request)
{
    $buscar = $request->input('buscar');

    $items = \App\Models\BiotecnologiaReactivos::query()
        ->when($buscar, function ($query, $buscar) {
            $query->where('nombre_item', 'like', "%{$buscar}%")
                  ->orWhere('detalle', 'like', "%{$buscar}%");
        })
        ->orderBy('id', 'desc')
        ->paginate(10) // 👈 Muestra solo 10 por página
        ->withQueryString(); // 👈 Mantiene el valor del filtro al cambiar de página

    return view('labs.biotecnologia.reactivos.index', compact('items', 'buscar'));
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
}
