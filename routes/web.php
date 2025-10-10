<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventarioController;

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
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/export-pdf', [DashboardController::class, 'exportPDF'])->name('dashboard.export.pdf');
    Route::get('/dashboard/export-excel', [DashboardController::class, 'exportExcel'])->name('dashboard.export.excel');
    
    // Rutas del inventario
    Route::resource('inventario', InventarioController::class);
});
