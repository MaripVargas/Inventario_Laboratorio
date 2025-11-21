<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MicrobiologiaReactivos extends Model
{
    use HasFactory;

        protected $table = 'microbiologia_reactivos';

    protected $fillable = [
        'nombre_reactivo',
        'cantidad',
        'unidad',
        'concentracion',
        'detalle',
    ];
}
