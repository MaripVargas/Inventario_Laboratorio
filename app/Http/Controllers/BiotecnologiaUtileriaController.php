<?php

namespace App\Http\Controllers;

use App\Models\BiotecnologiaUtileria;
use Illuminate\Http\Request;


class BiotecnologiaUtileriaController extends Controller
{
    /**
     * Mostrar todos los registros
     */
    public function index()
    {
       $items = BiotecnologiaUtileria::orderBy('id', 'desc')->get();
return view('labs.biotecnologia.utileria.index', compact('items'));

    }

    /**
     * Mostrar formulario para crear nuevo registro
     */
    public function create()
    {
        return view('labs.biotecnologia.utileria.create');
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

        BiotecnologiaUtileria::create($request->all());

        return redirect()->route('biotecnologia.utileria.index')
                         ->with('success', 'Artículo agregado correctamente.');
    }

    /**
     * Mostrar formulario de edición
     */
public function edit($id)
{
    try {
        $item = BiotecnologiaUtileria::findOrFail($id); // <--- Cambiado Item por BiotecnologiaUtileria

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

        $item = BiotecnologiaUtileria::findOrFail($id);
        $item->update($request->all());

        return redirect()->route('biotecnologia.utileria.index')
                         ->with('success', 'Artículo actualizado correctamente.');
    }

    /**
     * Eliminar un registro
     */
    public function destroy($id)
    {
        $item = BiotecnologiaUtileria::findOrFail($id);
        $item->delete();

        return redirect()->route('biotecnologia.utileria.index')
                         ->with('success', 'Artículo eliminado correctamente.');
    }
}
