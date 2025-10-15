<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Agregar columnas solo si no existen
        if (!Schema::hasColumn('inventario', 'iv_id')) {
            Schema::table('inventario', function (Blueprint $table) {
                $table->string('iv_id')->nullable()->after('ir_id');
            });
        }

        if (!Schema::hasColumn('inventario', 'uso')) {
            Schema::table('inventario', function (Blueprint $table) {
                $table->string('uso')->nullable()->after('estado');
            });
        }

        if (!Schema::hasColumn('inventario', 'contrato')) {
            Schema::table('inventario', function (Blueprint $table) {
                $table->string('contrato')->nullable()->after('uso');
            });
        }

        if (!Schema::hasColumn('inventario', 'nombre_responsable')) {
            Schema::table('inventario', function (Blueprint $table) {
                $table->string('nombre_responsable')->nullable()->after('contrato');
            });
        }

        if (!Schema::hasColumn('inventario', 'cedula')) {
            Schema::table('inventario', function (Blueprint $table) {
                $table->string('cedula', 50)->nullable()->after('nombre_responsable');
            });
        }

        if (!Schema::hasColumn('inventario', 'vinculacion')) {
            Schema::table('inventario', function (Blueprint $table) {
                $table->string('vinculacion')->nullable()->after('cedula');
            });
        }
    }

    public function down(): void
    {
        Schema::table('inventario', function (Blueprint $table) {
            $table->dropColumn(['iv_id','uso','contrato','nombre_responsable','cedula','vinculacion']);
        });
    }
};


