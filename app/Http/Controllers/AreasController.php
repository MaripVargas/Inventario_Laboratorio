<?php

namespace App\Http\Controllers;

class AreasController extends Controller
{
    public function index()
    {
        $areas = [
            [
                'nombre' => 'Lab. Zoología y Botánica',
                'ruta' => route('inventario.index'),
                'icono' => 'fas fa-leaf'
            ],
            [
                'nombre' => 'Lab. Biotecnología Vegetal',
                'ruta' => route('biotecnologia.index'),
                'icono' => 'fas fa-seedling'
            ],
            [
                'nombre' => 'Lab. Físico Química',
                'ruta' => route('fisicoquimica.index'),
                'icono' => 'fas fa-flask'
            ],
            [
                'nombre' => 'Lab. Microbiología',
                'ruta' => route('microbiologia.index'),
                'icono' => 'fas fa-bacteria'
            ],
        ];

        return view('areas.index', [
            'areas' => $areas,
            'totalAreas' => count($areas),
        ]);
    }
}


