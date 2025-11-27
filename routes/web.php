<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\BiotecnologiaController;
use App\Http\Controllers\FisicoQuimicaController;
use App\Http\Controllers\FisicoquimicaAdsorcionAtomicaController;
use App\Http\Controllers\FisicoquimicaSecadoSuelosController;
use App\Http\Controllers\FisicoquimicaAreaAdministrativaController;
use App\Http\Controllers\FisicoquimicaDepositoController;
use App\Http\Controllers\FisicoquimicaAreaBalanzasController;
use App\Http\Controllers\FisicoquimicaLaboratorioAnalisisController;
use App\Http\Controllers\FisicoquimicaAdsorcionAtomicaEquiposController;
use App\Http\Controllers\FisicoquimicaSecadoSuelosEquiposController;
use App\Http\Controllers\FisicoquimicaDepositoEquiposController;
use App\Http\Controllers\FisicoquimicaAreaBalanzasEquiposController;
use App\Http\Controllers\FisicoquimicaLaboratorioAnalisisEquiposController;
use App\Http\Controllers\MicrobiologiaController;
use App\Http\Controllers\BiotecnologiaUtileriaController;
use App\Http\Controllers\BiotecnologiaVidrieriaController;
use App\Http\Controllers\BiotecnologiaReactivosController;
use App\Http\Controllers\BiotecnologiaSiembraController;
use App\Http\Controllers\BiotecnologiaSiembraEquiposController;
use App\Http\Controllers\BiotecnologiaIncubacionController;

use App\Http\Controllers\ZoologiaVidrieriaController;
use App\Http\Controllers\ZoologiaUtileriaController;
use App\Http\Controllers\ZoologiaReactivosController;
use App\Http\Controllers\MicrobiologiaUtileriaController;
use App\Http\Controllers\MicrobiologiaVidrieriaController;      
use App\Http\Controllers\MicrobiologiaReactivosController;
use App\Http\Controllers\AreasController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Ruta principal - redirige al dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Rutas protegidas con autenticación simulada
Route::middleware(['simulate.auth'])->group(function () {
    
    // ========================================
    // DASHBOARD ROUTES
    // ========================================
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Dashboard Export Routes
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        // Exportar PDF completo (todos los registros)
        Route::get('/export-pdf', [DashboardController::class, 'exportPDF'])->name('export.pdf');
        
        // Exportar PDF paginado (útil para inventarios grandes)
        Route::get('/export-pdf-paginated', [DashboardController::class, 'exportPDFPaginated'])->name('export.pdf.paginated');
        
        // Exportar Excel
        Route::get('/export-excel', [DashboardController::class, 'exportExcel'])->name('export.excel');
        
        // Vista previa del PDF (para testing)
        Route::get('/preview-pdf', [DashboardController::class, 'previewPDF'])->name('preview.pdf');
    });
    
    // ========================================
    // INVENTARIO ROUTES
    // ========================================
    Route::resource('inventario', InventarioController::class);
    
    // Rutas adicionales de inventario si las necesitas
    Route::prefix('inventario')->name('inventario.')->group(function () {
        // Ejemplo: Exportar inventario individual
        // Route::get('/{id}/export-pdf', [InventarioController::class, 'exportItemPDF'])->name('item.export.pdf');
        
        // Ejemplo: Búsqueda avanzada
        // Route::get('/search', [InventarioController::class, 'search'])->name('search');
    });

    // ========================================
    // MÓDULOS DE LABORATORIO
    // ========================================
    Route::get('/biotecnologia', [BiotecnologiaController::class, 'index'])->name('biotecnologia.index');
    Route::get('/biotecnologia/create', [BiotecnologiaController::class, 'create'])->name('biotecnologia.create');


    Route::get('/fisicoquimica', [FisicoQuimicaController::class, 'index'])->name('fisicoquimica.index');
    Route::get('/fisicoquimica/create', [FisicoQuimicaController::class, 'create'])->name('fisicoquimica.create');

    Route::get('/microbiologia', [MicrobiologiaController::class, 'index'])->name('microbiologia.index');
    Route::get('/microbiologia/create', [MicrobiologiaController::class, 'create'])->name('microbiologia.create');

    // ========================================
    // ÁREAS
    // ========================================
    Route::get('/areas', [AreasController::class, 'index'])->name('areas.index');

   Route::prefix('zoologia')->group(function () {
    Route::resource('utileria', ZoologiaUtileriaController::class)->names('zoologia.utileria');
    Route::get('utileria/export/pdf', [ZoologiaUtileriaController::class, 'exportPdf'])->name('zoologia.utileria.export.pdf');
    Route::get('utileria/export/excel', [ZoologiaUtileriaController::class, 'exportExcel'])->name('zoologia.utileria.export.excel');

    Route::resource('vidrieria', ZoologiaVidrieriaController::class)->names('zoologia.vidrieria');
    Route::get('vidrieria/export/pdf', [ZoologiaVidrieriaController::class, 'exportPdf'])->name('zoologia.vidrieria.export.pdf');
    Route::get('vidrieria/export/excel', [ZoologiaVidrieriaController::class, 'exportExcel'])->name('zoologia.vidrieria.export.excel');

    Route::resource('reactivos', ZoologiaReactivosController::class)->names('zoologia.reactivos');
    Route::get('reactivos/export/pdf', [ZoologiaReactivosController::class, 'exportPdf'])->name('zoologia.reactivos.export.pdf');
    Route::get('reactivos/export/excel', [ZoologiaReactivosController::class, 'exportExcel'])->name('zoologia.reactivos.export.excel');
   
});

   Route::prefix('microbiologia')->group(function () {
    Route::resource('utileria', MicrobiologiaUtileriaController::class)->names('microbiologia.utileria');
    Route::resource('vidrieria', MicrobiologiaUtileriaController::class)->names('microbiologia.vidrieria');
    Route::resource('reactivos', MicrobiologiaUtileriaController::class)->names('microbiologia.reactivos');
   
});

});

Route::prefix('fisicoquimica')->name('fisicoquimica.')->middleware(['simulate.auth'])->group(function () {
    Route::resource('adsorcion-atomica', FisicoquimicaAdsorcionAtomicaController::class)
        ->names('adsorcion');
    Route::get('adsorcion-atomica/export/pdf', [FisicoquimicaAdsorcionAtomicaController::class, 'exportPdf'])
        ->name('adsorcion.export.pdf');
    Route::get('adsorcion-atomica/export/excel', [FisicoquimicaAdsorcionAtomicaController::class, 'exportExcel'])
        ->name('adsorcion.export.excel');

    Route::resource('adsorcion-atomica-equipos', FisicoquimicaAdsorcionAtomicaEquiposController::class)
        ->names('adsorcion_equipos');
    Route::get('adsorcion-atomica-equipos/export/pdf', [FisicoquimicaAdsorcionAtomicaEquiposController::class, 'exportPdf'])
        ->name('adsorcion_equipos.export.pdf');
    Route::get('adsorcion-atomica-equipos/export/excel', [FisicoquimicaAdsorcionAtomicaEquiposController::class, 'exportExcel'])
        ->name('adsorcion_equipos.export.excel');

    Route::resource('secado-suelos', FisicoquimicaSecadoSuelosController::class)
        ->names('secado_suelos');
    Route::get('secado-suelos/export/pdf', [FisicoquimicaSecadoSuelosController::class, 'exportPdf'])
        ->name('secado_suelos.export.pdf');
    Route::get('secado-suelos/export/excel', [FisicoquimicaSecadoSuelosController::class, 'exportExcel'])
        ->name('secado_suelos.export.excel');

    Route::resource('secado-suelos-equipos', FisicoquimicaSecadoSuelosEquiposController::class)
        ->names('secado_suelos_equipos');
    Route::get('secado-suelos-equipos/export/pdf', [FisicoquimicaSecadoSuelosEquiposController::class, 'exportPdf'])
        ->name('secado_suelos_equipos.export.pdf');
    Route::get('secado-suelos-equipos/export/excel', [FisicoquimicaSecadoSuelosEquiposController::class, 'exportExcel'])
        ->name('secado_suelos_equipos.export.excel');

    Route::resource('area-administrativa', FisicoquimicaAreaAdministrativaController::class)
        ->names('area_administrativa');
    Route::get('area-administrativa/export/pdf', [FisicoquimicaAreaAdministrativaController::class, 'exportPdf'])
        ->name('area_administrativa.export.pdf');
    Route::get('area-administrativa/export/excel', [FisicoquimicaAreaAdministrativaController::class, 'exportExcel'])
        ->name('area_administrativa.export.excel');

    Route::resource('deposito', FisicoquimicaDepositoController::class)
        ->names('deposito');
    Route::get('deposito/export/pdf', [FisicoquimicaDepositoController::class, 'exportPdf'])
        ->name('deposito.export.pdf');
    Route::get('deposito/export/excel', [FisicoquimicaDepositoController::class, 'exportExcel'])
        ->name('deposito.export.excel');

    Route::resource('deposito-equipos', FisicoquimicaDepositoEquiposController::class)
        ->names('deposito_equipos');
    Route::get('deposito-equipos/export/pdf', [FisicoquimicaDepositoEquiposController::class, 'exportPdf'])
        ->name('deposito_equipos.export.pdf');
    Route::get('deposito-equipos/export/excel', [FisicoquimicaDepositoEquiposController::class, 'exportExcel'])
        ->name('deposito_equipos.export.excel');

    Route::resource('area-balanzas', FisicoquimicaAreaBalanzasController::class)
        ->names('area_balanzas');
    Route::get('area-balanzas/export/pdf', [FisicoquimicaAreaBalanzasController::class, 'exportPdf'])
        ->name('area_balanzas.export.pdf');
    Route::get('area-balanzas/export/excel', [FisicoquimicaAreaBalanzasController::class, 'exportExcel'])
        ->name('area_balanzas.export.excel');

    Route::resource('area-balanzas-equipos', FisicoquimicaAreaBalanzasEquiposController::class)
        ->names('area_balanzas_equipos');
    Route::get('area-balanzas-equipos/export/pdf', [FisicoquimicaAreaBalanzasEquiposController::class, 'exportPdf'])
        ->name('area_balanzas_equipos.export.pdf');
    Route::get('area-balanzas-equipos/export/excel', [FisicoquimicaAreaBalanzasEquiposController::class, 'exportExcel'])
        ->name('area_balanzas_equipos.export.excel');

    Route::resource('laboratorio-analisis', FisicoquimicaLaboratorioAnalisisController::class)
        ->names('laboratorio_analisis');
    Route::get('laboratorio-analisis/export/pdf', [FisicoquimicaLaboratorioAnalisisController::class, 'exportPdf'])
        ->name('laboratorio_analisis.export.pdf');
    Route::get('laboratorio-analisis/export/excel', [FisicoquimicaLaboratorioAnalisisController::class, 'exportExcel'])
        ->name('laboratorio_analisis.export.excel');

    Route::resource('laboratorio-analisis-equipos', FisicoquimicaLaboratorioAnalisisEquiposController::class)
        ->names('laboratorio_analisis_equipos');
    Route::get('laboratorio-analisis-equipos/export/pdf', [FisicoquimicaLaboratorioAnalisisEquiposController::class, 'exportPdf'])
        ->name('laboratorio_analisis_equipos.export.pdf');
    Route::get('laboratorio-analisis-equipos/export/excel', [FisicoquimicaLaboratorioAnalisisEquiposController::class, 'exportExcel'])
        ->name('laboratorio_analisis_equipos.export.excel');
});

Route::get('{modulo}/export/pdf', [InventarioController::class, 'exportPdf'])->name('inventario.pdf');
   Route::get('{modulo}/export/excel', [InventarioController::class, 'exportExcel'])->name('inventario.excel');

// Rutas para Submenu de Biotecnología
Route::prefix('biotecnologia')->group(function () {
    Route::resource('utileria', BiotecnologiaUtileriaController::class)->names('biotecnologia.utileria');
    Route::get('utileria/export/pdf', [BiotecnologiaUtileriaController::class, 'exportPdf'])->name('biotecnologia.utileria.export.pdf');
    Route::get('utileria/export/excel', [BiotecnologiaUtileriaController::class, 'exportExcel'])->name('biotecnologia.utileria.export.excel');

    Route::resource('vidrieria', BiotecnologiaVidrieriaController::class)->names('biotecnologia.vidrieria');
    Route::get('vidrieria/export/pdf', [BiotecnologiaVidrieriaController::class, 'exportPdf'])->name('biotecnologia.vidrieria.export.pdf');
    Route::get('vidrieria/export/excel', [BiotecnologiaVidrieriaController::class, 'exportExcel'])->name('biotecnologia.vidrieria.export.excel');

    Route::resource('reactivos', BiotecnologiaReactivosController::class)->names('biotecnologia.reactivos');
    Route::get('reactivos/export/pdf', [BiotecnologiaReactivosController::class, 'exportPdf'])->name('biotecnologia.reactivos.export.pdf');
    Route::get('reactivos/export/excel', [BiotecnologiaReactivosController::class, 'exportExcel'])->name('biotecnologia.reactivos.export.excel');

    Route::resource('siembra', BiotecnologiaSiembraController::class)->names('biotecnologia.siembra');
    Route::get('siembra/export/pdf', [BiotecnologiaSiembraController::class, 'exportPdf'])->name('biotecnologia.siembra.export.pdf');
    Route::get('siembra/export/excel', [BiotecnologiaSiembraController::class, 'exportExcel'])->name('biotecnologia.siembra.export.excel');
    // Ruta adicional para edición en página (además del modal JSON)
    Route::get('siembra/{id}/editar', [BiotecnologiaSiembraController::class, 'editForm'])->name('biotecnologia.siembra.editForm');
    Route::resource('siembra-equipos', BiotecnologiaSiembraEquiposController::class)->names('biotecnologia.siembra_equipos');
    Route::get('siembra-equipos/export/pdf', [BiotecnologiaSiembraEquiposController::class, 'exportPdf'])->name('biotecnologia.siembra_equipos.export.pdf');
    Route::get('siembra-equipos/export/excel', [BiotecnologiaSiembraEquiposController::class, 'exportExcel'])->name('biotecnologia.siembra_equipos.export.excel');
    Route::resource('incubacion', BiotecnologiaIncubacionController::class)->names('biotecnologia.incubacion');
    Route::get('incubacion/export/pdf', [BiotecnologiaIncubacionController::class, 'exportPdf'])->name('biotecnologia.incubacion.export.pdf');
    Route::get('incubacion/export/excel', [BiotecnologiaIncubacionController::class, 'exportExcel'])->name('biotecnologia.incubacion.export.excel');

    

});