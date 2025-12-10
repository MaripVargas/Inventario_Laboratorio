<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDetalleToFechaUltimoMantenimientoInEquiposTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fecha_ultimo_mantenimiento_in_equipos_tables', function (Blueprint $table) {
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fecha_ultimo_mantenimiento_in_equipos_tables', function (Blueprint $table) {
            //
        });
    }
}
