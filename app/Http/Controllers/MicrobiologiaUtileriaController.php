<?php

namespace App\Http\Controllers;

use App\Models\MicrobiologiaUtileria;
use Illuminate\Http\Request;


class MicrobiologiaUtileriaController extends Controller
{
    /**
     * Mostrar todos los registros
     */
     public function index(Request $request)
{
    $buscar = $request->input('buscar');

    $items = \App\Models\MicrobiologiaUtileria::query()
        ->when($buscar, function ($query, $buscar) {
            $query->where('nombre_item', 'like', "%{$buscar}%")
                  ->orWhere('detalle', 'like', "%{$buscar}%");
        })
        ->orderBy('id', 'desc')
        ->paginate(10) // 👈 Muestra solo 10 por página
        ->withQueryString(); // 👈 Mantiene el valor del filtro al cambiar de página

    return view('labs.microbiologia.utileria.index', compact('items', 'buscar'));
}


    /**
     * Mostrar formulario para crear nuevo registro
     */
    public function create()
    {
        return view('labs.microbiologia.utileria.create');
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

        MicrobiologiaUtileria::create($request->all());

        return redirect()->route('microbiologia.utileria.index')
                         ->with('success', 'Artículo agregado correctamente.');
    }

    /**
     * Mostrar formulario de edición
     */
public function edit($id)
{
    try {
        $item =MicrobiologiaUtileria::findOrFail($id); // <--- Cambiado Item por BiotecnologiaUtileria

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

        $item = MicrobiologiaUtileria::findOrFail($id);
        $item->update($request->all());

        return redirect()->route('microbiologia.utileria.index')
                         ->with('success', 'Artículo actualizado correctamente.');
    }

    /**
     * Eliminar un registro
     */
    public function destroy($id)
    {
        $item = MicrobiologiaUtileria::findOrFail($id);
        $item->delete();

        return redirect()->route('microbiologia.utileria.index')
                         ->with('success', 'Artículo eliminado correctamente.');
    }
}
