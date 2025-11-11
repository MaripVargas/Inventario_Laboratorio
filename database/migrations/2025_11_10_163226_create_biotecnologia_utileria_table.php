<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBiotecnologiaUtileriaTable extends Migration
{
    public function up(): void
    {
        Schema::create('biotecnologia_utileria', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_item');
            $table->integer('cantidad')->nullable();
            $table->string('unidad')->nullable(); // unidad de medida
            $table->string('detalle')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('biotecnologia_utileria');
    }
}



