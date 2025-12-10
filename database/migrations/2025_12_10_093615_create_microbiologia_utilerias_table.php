<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMicrobiologiaUtileriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::create('microbiologia_utilerias', function (Blueprint $table) {
         $table->id();
            $table->string('nombre_item');
            $table->integer('cantidad')->nullable();
            $table->string('unidad')->nullable(); // unidad de medida
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
        Schema::dropIfExists('microbiologia_utilerias');
    }
}