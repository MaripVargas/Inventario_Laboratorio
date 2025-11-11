<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('biotecnologia_siembra', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_siembra');
            $table->integer('cantidad')->nullable();
            $table->string('unidad')->nullable();
            $table->string('detalle')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('biotecnologia_siembra');
    }
};


