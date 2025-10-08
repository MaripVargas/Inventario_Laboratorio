<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateInventarioTableAddNewFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inventario', function (Blueprint $table) {
            // Eliminar campos antiguos
            $table->dropColumn([
                'codigo', 'nombre', 'categoria', 'stock_actual', 'stock_minimo', 
                'unidad_medida', 'marca', 'modelo', 'numero_serie', 
                'ubicacion', 'proveedor', 'descripcion'
            ]);
            
            // Agregar nuevos campos
            $table->string('ir_id')->unique();
            $table->string('cod_regional');
            $table->string('cod_centro');
            $table->string('desc_almacen');
            $table->string('no_placa');
            $table->string('consecutivo');
            $table->string('desc_sku');
            $table->text('descripcion_elemento');
            $table->text('atributos')->nullable();
            $table->string('serial')->nullable();
            $table->date('fecha_adq');
            $table->decimal('valor_adq', 15, 2);
            $table->string('gestion');
            $table->text('acciones')->nullable();
            $table->string('foto')->nullable();
            $table->enum('estado', ['bueno', 'regular', 'malo'])->default('bueno');
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
            // Eliminar nuevos campos
            $table->dropColumn([
                'ir_id', 'cod_regional', 'cod_centro', 'desc_almacen', 
                'no_placa', 'consecutivo', 'desc_sku', 'descripcion_elemento',
                'atributos', 'serial', 'fecha_adq', 'valor_adq', 'gestion',
                'acciones', 'foto', 'estado'
            ]);
            
            // Restaurar campos antiguos
            $table->string('codigo')->unique();
            $table->string('nombre');
            $table->string('categoria');
            $table->integer('stock_actual')->default(0);
            $table->integer('stock_minimo')->nullable();
            $table->string('unidad_medida')->nullable();
            $table->string('marca')->nullable();
            $table->string('modelo')->nullable();
            $table->string('numero_serie')->nullable();
            $table->string('ubicacion')->nullable();
            $table->string('proveedor')->nullable();
            $table->text('descripcion')->nullable();
        });
    }
}
