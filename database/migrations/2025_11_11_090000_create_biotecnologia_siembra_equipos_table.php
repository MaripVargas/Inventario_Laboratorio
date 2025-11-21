<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('biotecnologia_siembra_equipos', function (Blueprint $table) {
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

    public function down(): void
    {
        Schema::dropIfExists('biotecnologia_siembra_equipos');
    }
};


