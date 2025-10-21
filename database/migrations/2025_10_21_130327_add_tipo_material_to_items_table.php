<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTipoMaterialToItemsTable extends Migration
{
    public function up()
    {
        Schema::table('inventario', function (Blueprint $table) {
            $table->string('tipo_material', 50)->nullable()->after('estado');
        });
    }

    public function down()
    {
        Schema::table('inventario', function (Blueprint $table) {
            $table->dropColumn('tipo_material');
        });
    }
}
