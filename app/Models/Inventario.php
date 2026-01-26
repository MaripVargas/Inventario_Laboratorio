<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    use HasFactory;

    protected $table = 'inventario';

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
        'fecha_mant',
        'acciones',
        'foto',
        'estado',
         'tipo_material',
        'uso',
        'contrato',
        'nombre_responsable',
        'cedula',
        'vinculacion',
        'lab_module',
        'usuario_registra',
        
    ];

    protected $casts = [
        'fecha_adq' => 'date',
        'fecha_mant' => 'date',
        'valor_adq' => 'decimal:2',
    ];
}
