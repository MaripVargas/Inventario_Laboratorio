<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('zoologia_vidrieria', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_item');
            $table->string('volumen')->nullable();
            $table->integer('cantidad')->nullable();
            $table->string('unidad')->nullable();
            $table->string('detalle')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('zoologia_vidrieria');
    }
};


