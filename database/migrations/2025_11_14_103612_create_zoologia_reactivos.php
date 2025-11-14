<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZoologiaReactivos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zoologia_reactivos', function (Blueprint $table) {
               $table->id();
            $table->string('nombre_reactivo');
            $table->integer('cantidad')->nullable();
            $table->string('unidad')->nullable(); // mL, L, tarro...
            $table->string('concentracion')->nullable(); // ej. "45%"
            $table->string('detalle')->nullable();
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
        Schema::dropIfExists('zoologia_reactivos');
    }
}
