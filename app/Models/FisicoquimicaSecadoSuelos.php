<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FisicoquimicaSecadoSuelos extends Model
{
    protected $table = 'fisicoquimica_secado_suelos';

    protected $fillable = [
        'nombre_item',
        'cantidad',
        'unidad',
        'detalle',
    ];
}


