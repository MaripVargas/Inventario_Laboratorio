<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MicrobiologiaVidrieria extends Model
{
    use HasFactory;

     protected $table = 'microbiologia_vidrierias';

    protected $fillable = [
        'nombre_item',
        'volumen',
        'cantidad',
        'unidad',
        'detalle',
    ];
}
