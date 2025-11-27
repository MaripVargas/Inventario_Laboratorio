<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFisicoquimicaSecadoSuelosEquiposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fisicoquimica_secado_suelos_equipos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->integer('cantidad')->nullable();
            $table->string('unidad')->nullable();
            $table->string('detalle')->nullable();
            $table->string('no_placa')->nullable();
            $table->date('fecha_adq')->nullable();
            $table->decimal('valor', 15, 2)->nullable();
            $table->string('nombre_responsable')->nullable();
            $table->string('cedula')->nullable();
            $table->string('vinculacion')->nullable();
            $table->date('fecha_registro')->nullable();
            $table->string('usuario_registra')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fisicoquimica_secado_suelos_equipos');
    }
}
