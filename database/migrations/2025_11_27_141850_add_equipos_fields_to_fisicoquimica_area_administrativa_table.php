<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEquiposFieldsToFisicoquimicaAreaAdministrativaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fisicoquimica_area_administrativa', function (Blueprint $table) {
            $table->string('no_placa')->nullable()->after('detalle');
            $table->date('fecha_adq')->nullable()->after('no_placa');
            $table->decimal('valor', 15, 2)->nullable()->after('fecha_adq');
            $table->string('nombre_responsable')->nullable()->after('valor');
            $table->string('cedula')->nullable()->after('nombre_responsable');
            $table->string('vinculacion')->nullable()->after('cedula');
            $table->date('fecha_registro')->nullable()->after('vinculacion');
            $table->string('usuario_registra')->nullable()->after('fecha_registro');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fisicoquimica_area_administrativa', function (Blueprint $table) {
            $table->dropColumn([
                'no_placa',
                'fecha_adq',
                'valor',
                'nombre_responsable',
                'cedula',
                'vinculacion',
                'fecha_registro',
                'usuario_registra',
            ]);
        });
    }
}
