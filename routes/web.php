<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\AreasController;

// Laboratorio general
use App\Http\Controllers\BiotecnologiaController;
use App\Http\Controllers\FisicoQuimicaController;
use App\Http\Controllers\MicrobiologiaController;

// Biotecnología - submódulos
use App\Http\Controllers\BiotecnologiaUtileriaController;
use App\Http\Controllers\BiotecnologiaVidrieriaController;
use App\Http\Controllers\BiotecnologiaReactivosController;
use App\Http\Controllers\BiotecnologiaSiembraController;

// Microbiología - submódulos
use App\Http\Controllers\MicrobiologiaUtileriaController;
use App\Http\Controllers\MicrobiologiaVidrieriaController;
use App\Http\Controllers\MicrobiologiaReactivosController;

// Zoología - submódulos
use App\Http\Controllers\ZoologiaUtileriaController;
use App\Http\Controllers\ZoologiaVidrieriaController;
use App\Http\Controllers\ZoologiaReactivosController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// =====================================================
// REDIRECCIÓN PRINCIPAL
// =====================================================
Route::get('/', function () {
    return redirect()->route('dashboard');
});


// =====================================================
// RUTAS PROTEGIDAS POR MIDDLEWARE
// =====================================================
Route::middleware(['simulate.auth'])->group(function () {

    // ========================================
    // DASHBOARD
    // ========================================
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/export-pdf', [DashboardController::class, 'exportPDF'])->name('export.pdf');
        Route::get('/export-pdf-paginated', [DashboardController::class, 'exportPDFPaginated'])->name('export.pdf.paginated');
        Route::get('/export-excel', [DashboardController::class, 'exportExcel'])->name('export.excel');
        Route::get('/preview-pdf', [DashboardController::class, 'previewPDF'])->name('preview.pdf');
    });


    // ========================================
    // INVENTARIO
    // ========================================
    Route::resource('inventario', InventarioController::class);

    Route::prefix('inventario')->name('inventario.')->group(function () {
        // Ejemplos opcionales:
        // Route::get('/{id}/export-pdf', [InventarioController::class, 'exportItemPDF'])->name('item.export.pdf');
        // Route::get('/search', [InventarioController::class, 'search'])->name('search');
    });


    // ========================================
    // MÓDULOS GENERALES DE LABORATORIO
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


    // ========================================
    // ZOOLOGÍA - SUBMÓDULOS
    // ========================================
    Route::prefix('zoologia')->group(function () {
        Route::resource('utileria', ZoologiaUtileriaController::class)->names('zoologia.utileria');
        Route::resource('vidrieria', ZoologiaVidrieriaController::class)->names('zoologia.vidrieria');
        Route::resource('reactivos', ZoologiaReactivosController::class)->names('zoologia.reactivos');
    });


    // ========================================
    // MICROBIOLOGÍA - SUBMÓDULOS
    // ========================================
    Route::prefix('microbiologia')->group(function () {
        Route::resource('utileria', MicrobiologiaUtileriaController::class)->names('microbiologia.utileria');
        Route::resource('vidrieria', MicrobiologiaVidrieriaController::class)->names('microbiologia.vidrieria');
        Route::resource('reactivos', MicrobiologiaReactivosController::class)->names('microbiologia.reactivos');
    });

});


// =====================================================
// EXPORTS GENERALES (FUERA DEL MIDDLEWARE)
// =====================================================
Route::get('{modulo}/export/pdf', [InventarioController::class, 'exportPdf'])->name('inventario.pdf');
Route::get('{modulo}/export/excel', [InventarioController::class, 'exportExcel'])->name('inventario.excel');


// =====================================================
// BIOTECNOLOGÍA - SUBMÓDULOS
// =====================================================
Route::prefix('biotecnologia')->group(function () {
    Route::resource('utileria', BiotecnologiaUtileriaController::class)->names('biotecnologia.utileria');
    Route::resource('vidrieria', BiotecnologiaVidrieriaController::class)->names('biotecnologia.vidrieria');
    Route::resource('reactivos', BiotecnologiaReactivosController::class)->names('biotecnologia.reactivos');
    Route::resource('siembra', BiotecnologiaSiembraController::class)->names('biotecnologia.siembra');

    // Ruta adicional
    Route::get('siembra/{id}/editar', [BiotecnologiaSiembraController::class, 'editForm'])
        ->name('biotecnologia.siembra.editForm');
});
