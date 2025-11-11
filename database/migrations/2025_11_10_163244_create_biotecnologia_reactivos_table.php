<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBiotecnologiaReactivosTable extends Migration
{
    public function up(): void
    {
        Schema::create('biotecnologia_reactivos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_reactivo');
            $table->integer('cantidad')->nullable();
            $table->string('unidad')->nullable(); // mL, L, tarro...
            $table->string('concentracion')->nullable(); // ej. "45%"
            $table->string('detalle')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('biotecnologia_reactivos');
    }
}
