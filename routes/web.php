<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\BiotecnologiaController;
use App\Http\Controllers\FisicoQuimicaController;
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
    Route::resource('vidrieria', ZoologiaVidrieriaController::class)->names('zoologia.vidrieria');
    Route::resource('reactivos', ZoologiaReactivosController::class)->names('zoologia.reactivos');
   
});
});

Route::get('{modulo}/export/pdf', [InventarioController::class, 'exportPdf'])->name('inventario.pdf');
   Route::get('{modulo}/export/excel', [InventarioController::class, 'exportExcel'])->name('inventario.excel');

// Rutas para Submenu de Biotecnología
Route::prefix('biotecnologia')->group(function () {
    Route::resource('utileria', BiotecnologiaUtileriaController::class)->names('biotecnologia.utileria');
    Route::resource('vidrieria', BiotecnologiaVidrieriaController::class)->names('biotecnologia.vidrieria');
    Route::resource('reactivos', BiotecnologiaReactivosController::class)->names('biotecnologia.reactivos');
    Route::resource('siembra', BiotecnologiaSiembraController::class)->names('biotecnologia.siembra');
    // Ruta adicional para edición en página (además del modal JSON)
    Route::get('siembra/{id}/editar', [BiotecnologiaSiembraController::class, 'editForm'])->name('biotecnologia.siembra.editForm');
    Route::resource('siembra-equipos', BiotecnologiaSiembraEquiposController::class)->names('biotecnologia.siembra_equipos');
    Route::resource('incubacion', BiotecnologiaIncubacionController::class)->names('biotecnologia.incubacion');
});