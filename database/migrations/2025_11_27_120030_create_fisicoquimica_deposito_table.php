<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('fisicoquimica_deposito', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_item');
            $table->integer('cantidad')->nullable();
            $table->string('unidad')->nullable();
            $table->string('detalle')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fisicoquimica_deposito');
    }
};


