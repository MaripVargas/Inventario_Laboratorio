<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
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
public function edit($id)
{
    $item = Inventario::findOrFail($id);
    return view('inventario.edit', compact('item'));
}

 public function update(Request $request, $id)
    {
        // Validación
        $validated = $request->validate([
            'ir_id' => 'required|string|max:255',
            'cod_regional' => 'nullable|string|max:255',
            'cod_centro' => 'nullable|string|max:255',
            'desc_almacen' => 'nullable|string|max:255',
            'no_placa' => 'required|string|max:255',
            'consecutivo' => 'nullable|string|max:255',
            'desc_sku' => 'required|string|max:255',
            'descripcion_elemento' => 'required|string',
            'atributos' => 'nullable|string',
            'serial' => 'nullable|string|max:255',
            'fecha_adq' => 'required|date',
            'valor_adq' => 'required|numeric|min:0',
            'gestion' => 'nullable|string|max:255',
            'acciones' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'estado' => 'required|in:bueno,regular,malo',
        ], [
            // Mensajes personalizados en español
            'ir_id.required' => 'El campo IR ID es obligatorio',
            'no_placa.required' => 'El campo No. Placa es obligatorio',
            'desc_sku.required' => 'El campo Descripción SKU es obligatorio',
            'descripcion_elemento.required' => 'El campo Descripción del Elemento es obligatorio',
            'fecha_adq.required' => 'El campo Fecha de Adquisición es obligatorio',
            'fecha_adq.date' => 'La Fecha de Adquisición debe ser una fecha válida',
            'valor_adq.required' => 'El campo Valor de Adquisición es obligatorio',
            'valor_adq.numeric' => 'El Valor de Adquisición debe ser un número',
            'valor_adq.min' => 'El Valor de Adquisición debe ser mayor o igual a 0',
            'estado.required' => 'El campo Estado es obligatorio',
            'estado.in' => 'El Estado debe ser: bueno, regular o malo',
            'foto.image' => 'El archivo debe ser una imagen',
            'foto.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg o gif',
            'foto.max' => 'La imagen no debe superar los 2MB',
        ]);

        try {
            $item = Inventario::findOrFail($id);

            // Manejar la foto si se subió una nueva
            if ($request->hasFile('foto')) {
                // Eliminar la foto anterior si existe
                if ($item->foto && Storage::exists('public/' . $item->foto)) {
                    Storage::delete('public/' . $item->foto);
                }

                // Guardar la nueva foto
                $path = $request->file('foto')->store('inventario', 'public');
                $validated['foto'] = $path;
            }

            // Actualizar el item
            $item->update($validated);

            // Si la petición espera JSON (AJAX)
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Item actualizado correctamente',
                    'item' => $item
                ]);
            }

            // Si es una petición normal
            return redirect()->route('inventario.index')
                ->with('success', 'Item actualizado correctamente');

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Si hay errores de validación y es AJAX
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Hay errores en el formulario',
                    'errors' => $e->errors()
                ], 422);
            }

            // Si es petición normal, dejar que Laravel maneje los errores
            throw $e;

        } catch (\Exception $e) {
            // Error general
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error al actualizar el item: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Error al actualizar el item: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Elimina el item
     */
    public function destroy($id)
    {
        try {
            $item = Inventario::findOrFail($id);

            // Eliminar la foto si existe
            if ($item->foto && Storage::exists('public/' . $item->foto)) {
                Storage::delete('public/' . $item->foto);
            }

            $item->delete();

            return redirect()->route('inventario.index')
                ->with('success', 'Item eliminado correctamente');

        } catch (\Exception $e) {
            return redirect()->route('inventario.index')
                ->with('error', 'Error al eliminar el item: ' . $e->getMessage());
        }
    }
}
