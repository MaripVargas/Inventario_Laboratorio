<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiotecnologiaReactivos extends Model
{
    use HasFactory;

    protected $table = 'biotecnologia_reactivos';

    protected $fillable = [
        'nombre_reactivo',
        'cantidad',
        'unidad',
        'concentracion',
        'detalle',
    ];
}

