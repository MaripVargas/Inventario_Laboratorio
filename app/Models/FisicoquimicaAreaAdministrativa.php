<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FisicoquimicaAreaAdministrativa extends Model
{
    protected $table = 'fisicoquimica_area_administrativa';

    protected $fillable = [
        'nombre_item',
        'cantidad',
        'unidad',
        'detalle',
        'no_placa',
        'fecha_adq',
        'valor',
        'nombre_responsable',
        'cedula',
        'vinculacion',
        'fecha_registro',
        'usuario_registra',
    ];

    protected $casts = [
        'fecha_adq' => 'date',
        'fecha_registro' => 'date',
        'valor' => 'decimal:2',
    ];
}


