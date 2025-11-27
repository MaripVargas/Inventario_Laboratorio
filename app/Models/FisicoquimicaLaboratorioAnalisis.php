<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FisicoquimicaLaboratorioAnalisis extends Model
{
    protected $table = 'fisicoquimica_laboratorio_analisis';

    protected $fillable = [
        'nombre_item',
        'cantidad',
        'unidad',
        'detalle',
    ];
}


