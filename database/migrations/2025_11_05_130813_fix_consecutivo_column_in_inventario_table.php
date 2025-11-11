<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class FixConsecutivoColumnInInventarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Verificar si existe la columna 'cantidad' y renombrarla a 'consecutivo'
        if (Schema::hasColumn('inventario', 'cantidad') && !Schema::hasColumn('inventario', 'consecutivo')) {
            // Usar SQL directo para renombrar (más compatible con MySQL)
            DB::statement('ALTER TABLE `inventario` CHANGE `cantidad` `consecutivo` VARCHAR(255) NULL');
        } 
        // Si no existe 'cantidad' ni 'consecutivo', crear la columna 'consecutivo'
        elseif (!Schema::hasColumn('inventario', 'consecutivo')) {
            Schema::table('inventario', function (Blueprint $table) {
                $table->string('consecutivo')->nullable()->after('no_placa');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Si existe 'consecutivo', renombrarlo a 'cantidad'
        if (Schema::hasColumn('inventario', 'consecutivo') && !Schema::hasColumn('inventario', 'cantidad')) {
            DB::statement('ALTER TABLE `inventario` CHANGE `consecutivo` `cantidad` VARCHAR(255) NULL');
        }
    }
}
