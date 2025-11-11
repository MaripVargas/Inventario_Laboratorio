<?php

namespace App\Http\Controllers;

use App\Models\BiotecnologiaVidrieria;
use Illuminate\Http\Request;

class BiotecnologiaVidrieriaController extends Controller
{
    public function index()
    {
        $items = BiotecnologiaVidrieria::orderBy('id', 'desc')->get();
        return view('labs.biotecnologia.vidrieria.index', compact('items'));
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
        $item = BiotecnologiaVidrieria::findOrFail($id);
        return view('labs.biotecnologia.vidrieria.edit', compact('item'));
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
