<?php

namespace App\Http\Controllers;

use App\Models\BiotecnologiaIncubacion;
use App\Models\Inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BiotecnologiaIncubacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = BiotecnologiaIncubacion::query();

        // Filtro de búsqueda
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($subquery) use ($buscar) {
                $subquery->where('ir_id', 'like', "%{$buscar}%")
                         ->orWhere('desc_sku', 'like', "%{$buscar}%")
                         ->orWhere('descripcion_elemento', 'like', "%{$buscar}%");
            });
        }

        // Filtro por tipo de material
        if ($request->filled('tipo_material')) {
            $query->where('tipo_material', $request->tipo_material);
        }

        // Filtro por placa
        if ($request->filled('no_placa')) {
            $query->where('no_placa', 'like', "%{$request->no_placa}%");
        }

        // Filtro por responsable
        if ($request->filled('nombre_responsable')) {
            $query->where('nombre_responsable', $request->nombre_responsable);
        }

        $items = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->appends($request->all());

        return view('labs.biotecnologia.incubacion.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $catalogos = $this->getCatalogos();
        return view('labs.biotecnologia.incubacion.create', compact('catalogos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ir_id' => 'required|string|max:255|unique:biotecnologia_incubacion',
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
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'estado' => 'required|in:bueno,regular,malo',
            'tipo_material' => 'required|string|max:50',
            'uso' => 'required|string|max:255',
            'contrato' => 'required|string|max:255',
            'nombre_responsable' => 'nullable|string|max:255',
            'cedula' => 'nullable|string|max:50',
            'vinculacion' => 'nullable|string|max:255',
            'usuario_registra' => 'required|string|max:255',
        ]);

        $data = $request->all();

        // Manejar la subida de la foto
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $nombreFoto = time() . '_' . $foto->getClientOriginalName();
            $foto->move(public_path('uploads/biotecnologia_incubacion'), $nombreFoto);
            $data['foto'] = $nombreFoto;
        }

        BiotecnologiaIncubacion::create($data);

        return redirect()->route('biotecnologia.incubacion.index')
                        ->with('success', 'Item agregado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $item = BiotecnologiaIncubacion::findOrFail($id);
        return view('labs.biotecnologia.incubacion.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $item = BiotecnologiaIncubacion::findOrFail($id);
        $catalogos = $this->getCatalogos();
        return view('labs.biotecnologia.incubacion.edit', compact('item', 'catalogos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $item = BiotecnologiaIncubacion::findOrFail($id);

        $request->validate([
            'ir_id' => 'required|string|max:255|unique:biotecnologia_incubacion,ir_id,' . $id,
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
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'estado' => 'required|in:bueno,regular,malo',
            'tipo_material' => 'required|string|max:50',
            'uso' => 'required|string|max:255',
            'contrato' => 'required|string|max:255',
            'nombre_responsable' => 'nullable|string|max:255',
            'cedula' => 'nullable|string|max:50',
            'vinculacion' => 'nullable|string|max:255',
            'usuario_registra' => 'required|string|max:255',
        ]);

        $data = $request->all();

        // Manejar la subida de la foto
        if ($request->hasFile('foto')) {
            // Eliminar foto anterior si existe
            if ($item->foto && file_exists(public_path('uploads/biotecnologia_incubacion/' . $item->foto))) {
                unlink(public_path('uploads/biotecnologia_incubacion/' . $item->foto));
            }

            $foto = $request->file('foto');
            $nombreFoto = time() . '_' . $foto->getClientOriginalName();
            $foto->move(public_path('uploads/biotecnologia_incubacion'), $nombreFoto);
            $data['foto'] = $nombreFoto;
        }

        $item->update($data);

        return redirect()->route('biotecnologia.incubacion.index')
                        ->with('success', 'Item actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $item = BiotecnologiaIncubacion::findOrFail($id);

        // Eliminar foto si existe
        if ($item->foto && file_exists(public_path('uploads/biotecnologia_incubacion/' . $item->foto))) {
            unlink(public_path('uploads/biotecnologia_incubacion/' . $item->foto));
        }

        $item->delete();

        return redirect()->route('biotecnologia.incubacion.index')
                        ->with('success', 'Item eliminado exitosamente.');
    }

    /**
     * Obtener catálogos para los formularios
     */
    private function getCatalogos()
    {
        // Responsables por defecto (catálogo base)
        $defaultResponsables = collect([
            ['nombre_responsable' => 'Carolina Avila', 'cedula' => '28551046'],
            ['nombre_responsable' => 'Maria Goretti Ramirez', 'cedula' => '52962110'],
            ['nombre_responsable' => 'Alcy Rene Ceron', 'cedula' => '76316028'],
            ['nombre_responsable' => 'Yoli Dayana Moreno', 'cedula' => '34327134'],
            ['nombre_responsable' => 'Kathryn Yadira Pacheco Guzman', 'cedula' => '38142927'],
            ['nombre_responsable' => 'Pastrana Granados Eduardo', 'cedula' => '7719513'],
        ]);

        // Obtener responsables de la tabla de incubación
        $incubacionData = BiotecnologiaIncubacion::select('nombre_responsable', 'cedula', 'vinculacion', 'usuario_registra')->get();

        // Obtener responsables del inventario general
        $inventarioData = Inventario::select('nombre_responsable', 'cedula', 'vinculacion', 'usuario_registra')->get();

        // Combinar y asegurar unicidad para responsables
        $merged = $incubacionData->concat($inventarioData);

        $responsablesDb = $merged
            ->filter(fn ($item) => !empty($item->nombre_responsable))
            ->map(fn ($item) => [
                'nombre' => $item->nombre_responsable,
                'cedula' => $item->cedula,
            ]);

        // Combinar responsables por defecto con los de la BD
        $responsables = $defaultResponsables
            ->map(fn ($item) => [
                'nombre' => $item['nombre_responsable'],
                'cedula' => $item['cedula'],
            ])
            ->concat($responsablesDb)
            ->unique(fn ($item) => $item['nombre'] . '|' . ($item['cedula'] ?? ''))
            ->sortBy('nombre')
            ->values();

        // Vinculaciones por defecto
        $defaultVinculaciones = collect([
            'Funcionario Administrativo',
            'Contrato',
            'Provisional'
        ]);

        $vinculacionesDb = $merged
            ->pluck('vinculacion')
            ->filter()
            ->unique();

        // Combinar vinculaciones por defecto con las de la BD
        $vinculaciones = $defaultVinculaciones
            ->concat($vinculacionesDb)
            ->unique()
            ->sort()
            ->values();

        // Usuarios
        $usuarios = $merged
            ->pluck('usuario_registra')
            ->filter()
            ->unique()
            ->sort()
            ->values();

        return [
            'responsables' => $responsables,
            'vinculaciones' => $vinculaciones,
            'usuarios' => $usuarios,
        ];
    }
}


