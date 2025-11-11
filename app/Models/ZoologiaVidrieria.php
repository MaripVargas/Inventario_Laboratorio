<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZoologiaVidrieria extends Model
{
    use HasFactory;

    protected $table = 'zoologia_vidrieria';

    protected $fillable = [
        'nombre_item',
        'volumen',
        'cantidad',
        'unidad',
        'detalle',
    ];
}


