<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FisicoquimicaAreaBalanzas extends Model
{
    protected $table = 'fisicoquimica_area_balanzas';

    protected $fillable = [
        'nombre_item',
        'cantidad',
        'unidad',
        'detalle',
    ];
}


