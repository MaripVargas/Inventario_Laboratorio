<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FisicoquimicaAdsorcionAtomicaEquipo extends Model
{
    use HasFactory;

    protected $table = 'fisicoquimica_adsorcion_atomica_equipos';

    protected $fillable = [
        'nombre',
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

