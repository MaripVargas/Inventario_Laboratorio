<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Inventario;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InventarioExport;

class InventarioController extends Controller
{

   
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
{
    // Iniciar la consulta base
    $query = Inventario::where('lab_module', 'zoologia_botanica');

    // 🔍 Filtro por tipo de material
    if ($request->filled('tipo_material')) {
        $query->where('tipo_material', $request->tipo_material);
    }
 // 🔹 Filtrado por nombre del responsable
    if ($request->filled('nombre_responsable')) {
        $query->where('nombre_responsable', $request->nombre_responsable);
    }

    // 🔎 Filtro de búsqueda (si agregaste el input "buscar")
    if ($request->filled('buscar')) {
        $buscar = $request->buscar;
        $query->where(function ($subquery) use ($buscar) {
            $subquery->where('ir_id', 'like', "%{$buscar}%")
                     ->orWhere('desc_sku', 'like', "%{$buscar}%")
                     ->orWhere('descripcion_elemento', 'like', "%{$buscar}%");
        });
    }

$items = $query->orderBy('created_at', 'desc')
    ->paginate(10)
    ->appends($request->all());

    // 📤 Retornar la vista
    return view('inventario.index', compact('items'));
}

    /**
     * Show the form for creating a new resource.
     */
  public function create()
{
    // Obtener lista de responsables únicos con su cédula de la base de datos
    $responsablesDb = Inventario::select('nombre_responsable', 'cedula')
        ->whereNotNull('nombre_responsable')
        ->where('nombre_responsable', '!=', '')
        ->groupBy('nombre_responsable', 'cedula')
        ->orderBy('nombre_responsable')
        ->get()
        ->map(function($item) {
            return [
                'nombre_responsable' => $item->nombre_responsable,
                'cedula' => $item->cedula
            ];
        });

    // Responsables por defecto (catálogo base)
    $defaultResponsables = collect([
        ['nombre_responsable' => 'Carolina Avila', 'cedula' => '28551046'],
        ['nombre_responsable' => 'Maria Goretti Ramirez', 'cedula' => '0987654321'],
        ['nombre_responsable' => 'Alcy Rene Ceron', 'cedula' => '76316028'],
        ['nombre_responsable' => 'Yoli Dayana Moreno', 'cedula' => '34327134'],
    ]);

    // Combinar y asegurar unicidad - TODOS SON ARRAYS AHORA
    $responsables = $defaultResponsables
        ->concat($responsablesDb)
        ->unique('nombre_responsable')
        ->sortBy('nombre_responsable')
        ->values();

    // Crear el catálogo con los datos necesarios para el formulario
    $catalogo = [
        'tipos_material' => ['Equipos', 'Mueblería', 'Vidrieria'],
        'estados' => ['bueno', 'regular', 'malo'],
        'gestiones' => ['GESTIONADO', 'SIN GESTIONAR'],
        'vinculaciones' => ['Funcionario Administrativo', 'Contrato', 'Provicional']
    ];

    return view('inventario.create', [
        'labModule' => 'zoologia_botanica',
        'responsables' => $responsables,
        'catalogo' => $catalogo
    ]);
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de datos
        $request->validate([
            'ir_id' => 'required|string|max:255|unique:inventario',
            'iv_id' => 'nullable|string|max:255',
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
             'tipo_material' => 'required|string|max:50',
            'uso' => 'nullable|string|max:255',
            'contrato' => 'nullable|string|max:255',
            'nombre_responsable' => 'nullable|string|max:255',
            'cedula' => 'nullable|string|max:50',
            'vinculacion' => 'nullable|string|max:255',
        ]);

        // Manejar la subida de la foto
        $data = $request->all();
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $nombreFoto = time() . '_' . $foto->getClientOriginalName();
            $foto->move(public_path('uploads/inventario'), $nombreFoto);
            $data['foto'] = $nombreFoto;
        }

        // Asignar lab_module según la ruta desde donde se accede
        $data['lab_module'] = $this->getLabModuleFromRequest($request);

        // Crear el nuevo item en la base de datos
        Inventario::create($data);

        // Redirigir según el módulo de origen
        $redirectRoute = $this->getRedirectRouteFromLabModule($data['lab_module']);
        
        return redirect()->route($redirectRoute)
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
    // Obtener lista de responsables únicos con su cédula
    $responsablesDb = Inventario::select('nombre_responsable', 'cedula')
        ->whereNotNull('nombre_responsable')
        ->where('nombre_responsable', '!=', '')
        ->groupBy('nombre_responsable', 'cedula')
        ->orderBy('nombre_responsable')
        ->get();

    // Responsables por defecto (catálogo base)
    $defaultResponsables = collect([
        ['nombre_responsable' => 'Carolina Avila', 'cedula' => '1234567890'],
        ['nombre_responsable' => 'Maria Goretti Ramirez',    'cedula' => '0987654321'],
        ['nombre_responsable' => 'Alcy Rene Ceron',     'cedula' => '76316028'],
        ['nombre_responsable' => 'Yoli Dayana Moreno',     'cedula' => '34327134'],
    ]);

    // Unir catálogo con los existentes en BD, sin duplicar por nombre
    $responsables = $defaultResponsables
        ->concat($responsablesDb)
        ->filter(function($r){ return !empty($r['nombre_responsable'] ?? $r->nombre_responsable); })
        ->map(function($r){
            return [
                'nombre_responsable' => is_array($r) ? $r['nombre_responsable'] : $r->nombre_responsable,
                'cedula' => is_array($r) ? $r['cedula'] : $r->cedula,
            ];
        })
        ->unique('nombre_responsable')
        ->sortBy('nombre_responsable')
        ->values();

    return view('inventario.edit', compact('item', 'responsables'));
}

 public function update(Request $request, $id)
    {
        // Validación
        $validated = $request->validate([
            'ir_id' => 'required|string|max:255',
            'iv_id' => 'nullable|string|max:255',
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
            'tipo_material' => 'required|string|max:50',
            'uso' => 'nullable|string|max:255',
            'contrato' => 'nullable|string|max:255',
            'nombre_responsable' => 'nullable|string|max:255',
            'cedula' => 'nullable|string|max:50',
            'vinculacion' => 'nullable|string|max:255',
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
                if ($item->foto && file_exists(public_path('uploads/inventario/' . $item->foto))) {
                    unlink(public_path('uploads/inventario/' . $item->foto));
                }

                // Guardar la nueva foto
                $foto = $request->file('foto');
                $nombreFoto = time() . '_' . $foto->getClientOriginalName();
                $foto->move(public_path('uploads/inventario'), $nombreFoto);
                $validated['foto'] = $nombreFoto;
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

            // Si es una petición normal, redirigir según el módulo del item
            $redirectRoute = $this->getRedirectRouteFromLabModule($item->lab_module);
            return redirect()->route($redirectRoute)
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
            if ($item->foto && file_exists(public_path('uploads/inventario/' . $item->foto))) {
                unlink(public_path('uploads/inventario/' . $item->foto));
            }

            // Guardar el lab_module antes de eliminar para redireccionar correctamente
            $labModule = $item->lab_module;
            $item->delete();

            // Redirigir según el módulo del item eliminado
            $redirectRoute = $this->getRedirectRouteFromLabModule($labModule);
            return redirect()->route($redirectRoute)
                ->with('success', 'Item eliminado correctamente');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al eliminar el item: ' . $e->getMessage());
        }
    }

    /**
     * Determina el lab_module basado en el request
     */
    private function getLabModuleFromRequest(Request $request)
    {
        // Verificar si viene un parámetro específico del módulo
        if ($request->has('lab_module')) {
            return $request->input('lab_module');
        }

        // Determinar por la URL de referencia
        $referer = $request->header('referer');
        
        if (str_contains($referer, 'biotecnologia')) {
            return 'biotecnologia_vegetal';
        } elseif (str_contains($referer, 'fisicoquimica')) {
            return 'fisico_quimica';
        } elseif (str_contains($referer, 'microbiologia')) {
            return 'microbiologia';
        } else {
            return 'zoologia_botanica'; // Por defecto
        }
    }

    /**
     * Obtiene la ruta de redirección basada en el lab_module
     */
    private function getRedirectRouteFromLabModule($labModule)
    {
        switch ($labModule) {
            case 'biotecnologia_vegetal':
                return 'biotecnologia.index';
            case 'fisico_quimica':
                return 'fisicoquimica.index';
            case 'microbiologia':
                return 'microbiologia.index';
            default:
                return 'inventario.index';
        }
    }

    
 
public function exportPdf($modulo)
{
    $inventario = Inventario::where('lab_module', $modulo)->get();
    
    $stats = [
        'total_items' => $inventario->count(),
        'total_value' => $inventario->sum('valor_adq'),
        'estado_bueno' => $inventario->where('estado', 'bueno')->count(),
        'estado_regular' => $inventario->where('estado', 'regular')->count(),
        'estado_malo' => $inventario->where('estado', 'malo')->count(),
        'gestiones' => $inventario->pluck('gestion')->unique()->count(),
    ];
    
    $pdf = PDF::loadView('inventario.pdf', compact('inventario', 'stats'));
    $pdf->setPaper('A4', 'portrait');
    
    return $pdf->download('inventario_' . $modulo . '_' . date('Y-m-d') . '.pdf');
}

public function exportExcel($modulo)
   {
       return Excel::download(new InventarioExport($modulo), 'inventario_' . $modulo . '_' . date('Y-m-d') . '.xlsx');
   }

}