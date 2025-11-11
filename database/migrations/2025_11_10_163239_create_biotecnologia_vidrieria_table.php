<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBiotecnologiaVidrieriaTable extends Migration
{
    public function up(): void
    {
        Schema::create('biotecnologia_vidrieria', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_item');
            $table->string('volumen')->nullable(); // ej. "500 ml"
            $table->integer('cantidad')->nullable();
            $table->string('unidad')->nullable(); // unidad de medida (si aplica)
            $table->string('detalle')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('biotecnologia_vidrieria');
    }
}
