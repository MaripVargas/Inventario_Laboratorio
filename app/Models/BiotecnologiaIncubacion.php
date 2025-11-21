<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiotecnologiaIncubacion extends Model
{
    use HasFactory;

    protected $table = 'biotecnologia_incubacion';

    protected $fillable = [
        'ir_id',
        'iv_id',
        'cod_regional',
        'cod_centro',
        'desc_almacen',
        'no_placa',
        'consecutivo',
        'desc_sku',
        'descripcion_elemento',
        'atributos',
        'serial',
        'fecha_adq',
        'valor_adq',
        'gestion',
        'foto',
        'estado',
        'tipo_material',
        'uso',
        'contrato',
        'nombre_responsable',
        'cedula',
        'vinculacion',
        'usuario_registra',
    ];

    protected $casts = [
        'fecha_adq' => 'date',
        'valor_adq' => 'decimal:2',
    ];
}


