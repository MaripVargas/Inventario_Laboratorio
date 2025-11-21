<?php

namespace App\Http\Controllers;

use App\Models\BiotecnologiaSiembraEquipo;
use App\Models\Inventario;
use Illuminate\Http\Request;

class BiotecnologiaSiembraEquiposController extends Controller
{
    public function index(Request $request)
    {
        $query = BiotecnologiaSiembraEquipo::query();

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('nombre', 'like', "%{$buscar}%")
                  ->orWhere('no_placa', 'like', "%{$buscar}%")
                  ->orWhere('nombre_responsable', 'like', "%{$buscar}%");
            });
        }

        $items = $query->orderByDesc('id')->get();

        return view('labs.biotecnologia.siembra_equipos.index', compact('items'));
    }

    public function create()
    {
        $catalogos = $this->getCatalogos();
        return view('labs.biotecnologia.siembra_equipos.create', compact('catalogos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'cantidad' => 'nullable|integer',
            'unidad' => 'nullable|string|max:100',
            'detalle' => 'nullable|string|max:500',
            'no_placa' => 'nullable|string|max:255',
            'fecha_adq' => 'nullable|date',
            'valor' => 'nullable|numeric|min:0',
            'nombre_responsable' => 'nullable|string|max:255',
            'cedula' => 'nullable|string|max:50',
            'vinculacion' => 'nullable|string|max:255',
            'fecha_registro' => 'nullable|date',
            'usuario_registra' => 'nullable|string|max:255',
        ]);

        BiotecnologiaSiembraEquipo::create($request->all());

        return redirect()->route('biotecnologia.siembra_equipos.index')
                         ->with('success', 'Equipo de siembra agregado correctamente.');
    }

    public function edit($id)
    {
        $item = BiotecnologiaSiembraEquipo::findOrFail($id);
        $catalogos = $this->getCatalogos();
        return view('labs.biotecnologia.siembra_equipos.edit', compact('item', 'catalogos'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'cantidad' => 'nullable|integer',
            'unidad' => 'nullable|string|max:100',
            'detalle' => 'nullable|string|max:500',
            'no_placa' => 'nullable|string|max:255',
            'fecha_adq' => 'nullable|date',
            'valor' => 'nullable|numeric|min:0',
            'nombre_responsable' => 'nullable|string|max:255',
            'cedula' => 'nullable|string|max:50',
            'vinculacion' => 'nullable|string|max:255',
            'fecha_registro' => 'nullable|date',
            'usuario_registra' => 'nullable|string|max:255',
        ]);

        $item = BiotecnologiaSiembraEquipo::findOrFail($id);
        $item->update($request->all());

        return redirect()->route('biotecnologia.siembra_equipos.index')
                         ->with('success', 'Equipo de siembra actualizado correctamente.');
    }

    public function destroy($id)
    {
        $item = BiotecnologiaSiembraEquipo::findOrFail($id);
        $item->delete();

        return redirect()->route('biotecnologia.siembra_equipos.index')
                         ->with('success', 'Equipo de siembra eliminado correctamente.');
    }

    private function getCatalogos()
    {
        $equipos = BiotecnologiaSiembraEquipo::select(
            'nombre_responsable',
            'cedula',
            'vinculacion',
            'usuario_registra'
        )->get();

        $inventario = Inventario::select(
            'nombre_responsable',
            'cedula',
            'vinculacion',
            'usuario_registra'
        )->get();

        $merged = $equipos->concat($inventario);

        $responsables = $merged
            ->filter(fn ($item) => !empty($item->nombre_responsable))
            ->map(fn ($item) => [
                'nombre' => $item->nombre_responsable,
                'cedula' => $item->cedula,
            ])
            ->unique(fn ($item) => $item['nombre'] . '|' . ($item['cedula'] ?? ''))
            ->sortBy('nombre')
            ->values();

        $pluckUnique = fn ($field) => $merged
            ->pluck($field)
            ->filter()
            ->unique()
            ->sort()
            ->values();

        return [
            'responsables' => $responsables,
            'cedulas' => $pluckUnique('cedula'),
            'vinculaciones' => $pluckUnique('vinculacion'),
            'usuarios' => $pluckUnique('usuario_registra'),
        ];
    }
}


