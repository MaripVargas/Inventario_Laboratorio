<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('biotecnologia_incubacion', function (Blueprint $table) {
            $table->id();
            $table->string('ir_id')->unique();
            $table->string('iv_id')->nullable();
            $table->string('cod_regional');
            $table->string('cod_centro');
            $table->string('desc_almacen');
            $table->string('no_placa');
            $table->string('consecutivo');
            $table->string('desc_sku');
            $table->text('descripcion_elemento');
            $table->text('atributos')->nullable();
            $table->string('serial')->nullable();
            $table->date('fecha_adq');
            $table->decimal('valor_adq', 15, 2);
            $table->string('gestion');
            $table->string('foto')->nullable();
            $table->enum('estado', ['bueno', 'regular', 'malo'])->default('bueno');
            $table->string('tipo_material');
            $table->string('uso');
            $table->string('contrato');
            $table->string('nombre_responsable')->nullable();
            $table->string('cedula', 50)->nullable();
            $table->string('vinculacion')->nullable();
            $table->string('usuario_registra')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biotecnologia_incubacion');
    }
};


