<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiotecnologiaSiembra extends Model
{
    use HasFactory;

    protected $table = 'biotecnologia_siembra';

    protected $fillable = [
        'nombre_siembra',
        'cantidad',
        'unidad',
        'detalle',
    ];
}


