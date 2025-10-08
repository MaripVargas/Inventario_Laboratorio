<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventario;

class InventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Inventario::orderBy('created_at', 'desc')->paginate(10);
        
        return view('inventario.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('inventario.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de datos
        $request->validate([
            'ir_id' => 'required|string|max:255|unique:inventario',
            'cod_regional' => 'required|string|max:255',
            'cod_centro' => 'required|string|max:255',
            'desc_almacen' => 'required|string|max:255',
            'no_placa' => 'required|string|max:255',
            'consecutivo' => 'required|string|max:255',
            'desc_sku' => 'required|string|max:255',
            'descripcion_elemento' => 'required|string',
            'atributos' => 'nullable|string',
            'serial' => 'nullable|string|max:255',
            'fecha_adq' => 'required|date',
            'valor_adq' => 'required|numeric|min:0',
            'gestion' => 'required|string|max:255',
            'acciones' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'estado' => 'required|in:bueno,regular,malo',
        ]);

        // Manejar la subida de la foto
        $data = $request->all();
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $nombreFoto = time() . '_' . $foto->getClientOriginalName();
            $foto->move(public_path('uploads/inventario'), $nombreFoto);
            $data['foto'] = $nombreFoto;
        }

        // Crear el nuevo item en la base de datos
        Inventario::create($data);

        return redirect()->route('inventario.index')
                        ->with('success', 'Item agregado exitosamente al inventario.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Implementar cuando sea necesario
        return view('inventario.show', compact('id'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Implementar cuando sea necesario
        return view('inventario.edit', compact('id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Implementar cuando sea necesario
        return redirect()->route('inventario.index')
                        ->with('success', 'Item actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Inventario::findOrFail($id);
        $item->delete();

        return redirect()->route('inventario.index')
                        ->with('success', 'Item eliminado exitosamente.');
    }
}
