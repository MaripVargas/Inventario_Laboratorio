<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fisicoquimicaVidrieria extends Model
{
    use HasFactory;

     protected $table = 'fisicoquimica_vidrieria';

    protected $fillable = [
        'nombre_item',
        'volumen',
        'cantidad',
        'unidad',
        'detalle',
    ];
}
