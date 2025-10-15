<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Asignar 'zoologia_botanica' como lab_module por defecto a todos los registros existentes
        DB::table('inventario')
            ->whereNull('lab_module')
            ->update(['lab_module' => 'zoologia_botanica']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Opcional: eliminar el lab_module de todos los registros
        DB::table('inventario')
            ->where('lab_module', 'zoologia_botanica')
            ->update(['lab_module' => null]);
    }
};