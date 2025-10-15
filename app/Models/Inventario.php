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
        'gestion',
        'acciones',
        'foto',
        'estado',
        // 👇 Nuevos campos añadidos
        'uso',
        'contrato',
        'nombre_responsable',
        'cedula',
        'vinculacion',
    ];

    protected $casts = [
        'fecha_adq' => 'date',
        'valor_adq' => 'decimal:2',
    ];
}
