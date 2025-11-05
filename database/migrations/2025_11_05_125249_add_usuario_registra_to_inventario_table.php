<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsuarioRegistraToInventarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inventario', function (Blueprint $table) {
            if (!Schema::hasColumn('inventario', 'usuario_registra')) {
                $table->string('usuario_registra')->nullable()->after('lab_module');
            }
            if (!Schema::hasColumn('inventario', 'fecha_registro')) {
                $table->datetime('fecha_registro')->nullable()->after('usuario_registra');
            }
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
            if (Schema::hasColumn('inventario', 'usuario_registra')) {
                $table->dropColumn('usuario_registra');
            }
            if (Schema::hasColumn('inventario', 'fecha_registro')) {
                $table->dropColumn('fecha_registro');
            }
        });
    }
}