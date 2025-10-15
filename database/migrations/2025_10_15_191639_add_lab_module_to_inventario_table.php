<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('inventario', function (Blueprint $table) {
            if (!Schema::hasColumn('inventario', 'lab_module')) {
                $table->string('lab_module', 50)->nullable()->after('vinculacion');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventario', function (Blueprint $table) {
            if (Schema::hasColumn('inventario', 'lab_module')) {
                $table->dropColumn('lab_module');
            }
        });
    }
};