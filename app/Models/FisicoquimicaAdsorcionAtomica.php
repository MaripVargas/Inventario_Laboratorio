<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FisicoquimicaAdsorcionAtomica extends Model
{
    protected $table = 'fisicoquimica_adsorcion_atomica';

    protected $fillable = [
        'nombre_item',
        'cantidad',
        'unidad',
        'detalle',
    ];
}


