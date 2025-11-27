<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FisicoquimicaDeposito extends Model
{
    protected $table = 'fisicoquimica_deposito';

    protected $fillable = [
        'nombre_item',
        'cantidad',
        'unidad',
        'detalle',
    ];
}


