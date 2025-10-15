<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\BiotecnologiaController;
use App\Http\Controllers\FisicoQuimicaController;
use App\Http\Controllers\MicrobiologiaController;
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
});

// ========================================
// RUTAS PÚBLICAS (si las necesitas)
// ========================================
// Route::get('/about', function () {
//     return view('about');
// })->name('about');