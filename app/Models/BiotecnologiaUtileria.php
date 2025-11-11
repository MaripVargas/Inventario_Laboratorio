<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiotecnologiaUtileria extends Model
{
    use HasFactory;

    protected $table = 'biotecnologia_utileria';

    protected $fillable = [
        'nombre_item',
        'cantidad',
        'unidad',
        'detalle',
    ];
}
