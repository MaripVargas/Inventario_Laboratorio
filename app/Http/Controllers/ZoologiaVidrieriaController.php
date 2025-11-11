<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ZoologiaVidrieria;

class ZoologiaVidrieriaController extends Controller
{
    public function index()
    {
        $items = ZoologiaVidrieria::orderByDesc('id')->get();
        return view('labs.zoologia.vidrieria.index', compact('items'));
    }

    public function create()
    {
        return view('labs.zoologia.vidrieria.create');
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

        ZoologiaVidrieria::create($request->all());

        return redirect()->route('zoologia.vidrieria.index')
                         ->with('success', 'Artículo de vidriería agregado correctamente.');
    }

    public function edit($id)
    {
        $item = ZoologiaVidrieria::findOrFail($id);
        return view('labs.zoologia.vidrieria.edit', compact('item'));
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

        $item = ZoologiaVidrieria::findOrFail($id);
        $item->update($request->all());

        return redirect()->route('zoologia.vidrieria.index')
                         ->with('success', 'Artículo de vidriería actualizado correctamente.');
    }

    public function destroy($id)
    {
        $item = ZoologiaVidrieria::findOrFail($id);
        $item->delete();

        return redirect()->route('zoologia.vidrieria.index')
                         ->with('success', 'Artículo de vidriería eliminado correctamente.');
    }
}


