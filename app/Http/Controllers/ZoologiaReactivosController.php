<?php

namespace App\Http\Controllers;

use App\Models\ZoologiaReactivos;
use Illuminate\Http\Request;

class ZoologiaReactivosController extends Controller
{
     public function index(Request $request)
{
    $buscar = $request->input('buscar');

    $items = \App\Models\ZoologiaReactivos::query()
        ->when($buscar, function ($query, $buscar) {
            $query->where('nombre_item', 'like', "%{$buscar}%")
                  ->orWhere('detalle', 'like', "%{$buscar}%");
        })
        ->orderBy('id', 'desc')
        ->paginate(10) // 👈 Muestra solo 10 por página
        ->withQueryString(); // 👈 Mantiene el valor del filtro al cambiar de página

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
}
