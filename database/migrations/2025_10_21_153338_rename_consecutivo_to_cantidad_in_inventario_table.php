<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameConsecutivoToCantidadInInventarioTable extends Migration

{
public function up(){
    Schema::table('inventario', function (Blueprint $table) {
        $table->renameColumn('consecutivo', 'cantidad');
    });
}

public function down()
{
    Schema::table('inventario', function (Blueprint $table) {
        $table->renameColumn('cantidad', 'consecutivo');
    });
}

}
