<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class RenameGestionToFechaMantInInventarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Verificar si la columna gestion existe antes de renombrarla
        if (Schema::hasColumn('inventario', 'gestion')) {
            // PASO 1: Primero modificar la columna para que acepte NULL
            $driver = DB::getDriverName();
            if ($driver === 'mysql') {
                DB::statement('ALTER TABLE inventario MODIFY gestion VARCHAR(255) NULL');
            }
            
            // PASO 2: Convertir valores de texto a null si no son fechas válidas
            DB::table('inventario')->whereNotNull('gestion')
                ->where(function($query) {
                    $query->where('gestion', 'SIN FECHA DE MANTENIMIENTO')
                          ->orWhere('gestion', 'SIN GESTIONAR')
                          ->orWhere('gestion', '');
                })
                ->update(['gestion' => null]);

            // PASO 3: Intentar convertir fechas válidas en formato string a date
            $items = DB::table('inventario')->whereNotNull('gestion')->get();
            foreach ($items as $item) {
                $fecha = null;
                if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $item->gestion)) {
                    $fecha = $item->gestion;
                } elseif (strtotime($item->gestion)) {
                    $fecha = date('Y-m-d', strtotime($item->gestion));
                }
                if ($fecha) {
                    DB::table('inventario')->where('id', $item->id)->update(['gestion' => $fecha]);
                } else {
                    DB::table('inventario')->where('id', $item->id)->update(['gestion' => null]);
                }
            }

            // PASO 4: Renombrar la columna y cambiar tipo a DATE
            if ($driver === 'mysql') {
                DB::statement('ALTER TABLE inventario CHANGE gestion fecha_mant DATE NULL');
            } elseif ($driver === 'sqlite') {
                // SQLite no soporta renombrar columnas directamente
                if (!Schema::hasColumn('inventario', 'fecha_mant')) {
                    Schema::table('inventario', function (Blueprint $table) {
                        $table->date('fecha_mant')->nullable()->after('valor_adq');
                    });
                    // Copiar datos
                    DB::statement('UPDATE inventario SET fecha_mant = gestion WHERE gestion IS NOT NULL');
                }
            } else {
                // Para otros drivers
                Schema::table('inventario', function (Blueprint $table) {
                    $table->renameColumn('gestion', 'fecha_mant');
                });
                Schema::table('inventario', function (Blueprint $table) {
                    $table->date('fecha_mant')->nullable()->change();
                });
            }
        } else if (!Schema::hasColumn('inventario', 'fecha_mant')) {
            // Si no existe gestion, crear fecha_mant
            Schema::table('inventario', function (Blueprint $table) {
                $table->date('fecha_mant')->nullable()->after('valor_adq');
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
        if (Schema::hasColumn('inventario', 'fecha_mant')) {
            $driver = DB::getDriverName();
            if ($driver === 'mysql') {
                DB::statement('ALTER TABLE inventario CHANGE fecha_mant gestion VARCHAR(255) NULL');
            } elseif ($driver === 'sqlite') {
                // Para SQLite, solo agregamos gestion si no existe
                if (!Schema::hasColumn('inventario', 'gestion')) {
                    Schema::table('inventario', function (Blueprint $table) {
                        $table->string('gestion')->nullable()->after('valor_adq');
                    });
                    // Copiar datos
                    DB::statement('UPDATE inventario SET gestion = fecha_mant WHERE fecha_mant IS NOT NULL');
                }
            } else {
                Schema::table('inventario', function (Blueprint $table) {
                    $table->renameColumn('fecha_mant', 'gestion');
                });
                Schema::table('inventario', function (Blueprint $table) {
                    $table->string('gestion')->nullable()->change();
                });
            }
        }
    }
}