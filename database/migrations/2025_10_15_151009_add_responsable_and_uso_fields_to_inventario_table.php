<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddResponsableAndUsoFieldsToInventarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inventario', function (Blueprint $table) {
            // Campos de Uso y Contratación
            $table->enum('uso', ['formacion', 'servicios_tecnologicos', 'investigacion'])->after('valor_adq');
            $table->string('contrato')->after('uso');
            
            // Campos de Información del Responsable
            $table->string('nombre_responsable')->after('contrato');
            $table->string('cedula')->after('nombre_responsable');
            $table->enum('vinculacion', ['contrato', 'funcionario_administrativo', 'provisional'])->after('cedula');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inventario', function (Blueprint $table) {
            $table->dropColumn([
                'uso',
                'contrato',
                'cuenta_dante',
                'nombre_responsable',
                'cedula',
                'vinculacion'
            ]);
        });
    }
}