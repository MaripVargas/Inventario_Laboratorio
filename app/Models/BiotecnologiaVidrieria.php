<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiotecnologiaVidrieria extends Model
{
    use HasFactory;

    protected $table = 'biotecnologia_vidrieria';

    protected $fillable = [
        'nombre_item',
        'volumen',
        'cantidad',
        'unidad',
        'detalle',
    ];
}

