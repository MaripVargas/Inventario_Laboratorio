<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZoologiaReactivos extends Model
{
    use HasFactory;

    protected $table = 'zoologia_reactivos';

    protected $fillable = [
        'nombre_reactivo',
        'cantidad',
        'unidad',
        'concentracion',
        'detalle',
    ];
}

