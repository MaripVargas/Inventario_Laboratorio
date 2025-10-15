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
        // Agregar de forma idempotente (solo si no existen)
        if (!Schema::hasColumn('inventario', 'uso')) {
            Schema::table('inventario', function (Blueprint $table) {
                $table->enum('uso', ['formacion', 'servicios_tecnologicos', 'investigacion'])->after('valor_adq');
            });
        }

        if (!Schema::hasColumn('inventario', 'contrato')) {
            Schema::table('inventario', function (Blueprint $table) {
                $table->string('contrato')->after('uso');
            });
        }

        if (!Schema::hasColumn('inventario', 'nombre_responsable')) {
            Schema::table('inventario', function (Blueprint $table) {
                $table->string('nombre_responsable')->after('contrato');
            });
        }

        if (!Schema::hasColumn('inventario', 'cedula')) {
            Schema::table('inventario', function (Blueprint $table) {
                $table->string('cedula')->after('nombre_responsable');
            });
        }

        if (!Schema::hasColumn('inventario', 'vinculacion')) {
            Schema::table('inventario', function (Blueprint $table) {
                $table->enum('vinculacion', ['contrato', 'funcionario_administrativo', 'provisional'])->after('cedula');
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
        Schema::table('inventario', function (Blueprint $table) {
            if (Schema::hasColumn('inventario', 'vinculacion')) $table->dropColumn('vinculacion');
            if (Schema::hasColumn('inventario', 'cedula')) $table->dropColumn('cedula');
            if (Schema::hasColumn('inventario', 'nombre_responsable')) $table->dropColumn('nombre_responsable');
            if (Schema::hasColumn('inventario', 'contrato')) $table->dropColumn('contrato');
            if (Schema::hasColumn('inventario', 'uso')) $table->dropColumn('uso');
        });
    }
}