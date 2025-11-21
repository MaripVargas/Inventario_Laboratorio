<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MicrobiologiaUtileria extends Model
{
    use HasFactory;

      protected $table = 'microbiologia_utilerias';

    protected $fillable = [
        'nombre_item',
        'cantidad',
        'unidad',
        'detalle',
    ];
}
