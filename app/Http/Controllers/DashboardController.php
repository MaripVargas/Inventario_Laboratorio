<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventario;
use App\Models\BiotecnologiaUtileria;
use App\Models\BiotecnologiaVidrieria;
use App\Models\BiotecnologiaReactivos;
use App\Models\BiotecnologiaSiembra;
use App\Models\BiotecnologiaIncubacion;
use App\Models\BiotecnologiaSiembraEquipo;
use App\Models\FisicoquimicaAdsorcionAtomica;
use App\Models\FisicoquimicaSecadoSuelos;
use App\Models\FisicoquimicaAreaAdministrativa;
use App\Models\FisicoquimicaDeposito;
use App\Models\FisicoquimicaAreaBalanzas;
use App\Models\FisicoquimicaLaboratorioAnalisis;
use App\Models\FisicoquimicaAdsorcionAtomicaEquipo;
use App\Models\FisicoquimicaSecadoSuelosEquipo;
use App\Models\FisicoquimicaDepositoEquipo;
use App\Models\FisicoquimicaAreaBalanzasEquipo;
use App\Models\FisicoquimicaLaboratorioAnalisisEquipo;
use App\Models\ZoologiaUtileria;
use App\Models\ZoologiaVidrieria;
use App\Models\ZoologiaReactivos;
use App\Models\MicrobiologiaUtileria;
use App\Models\MicrobiologiaVidrieria;
use App\Models\MicrobiologiaReactivos;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InventarioExport;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
   public function index()
{
    // Inventario General
    $totalItems = Inventario::count();
    $goodItems = Inventario::where('estado', 'bueno')->count();
    $badItems = Inventario::where('estado', 'malo')->count();
    $regularItems = Inventario::where('estado', 'regular')->count();
    
    // Biotecnología
    $biotecUtileria = BiotecnologiaUtileria::count();
    $biotecVidrieria = BiotecnologiaVidrieria::count();
    $biotecReactivos = BiotecnologiaReactivos::count();
    $biotecSiembra = BiotecnologiaSiembra::count();
    $biotecIncubacion = BiotecnologiaIncubacion::count();
    $biotecEquipos = BiotecnologiaSiembraEquipo::count();
    $totalBiotec = $biotecUtileria + $biotecVidrieria + $biotecReactivos + $biotecSiembra + $biotecIncubacion + $biotecEquipos;
    
    // Físico Química
    $fqAdsorcion = FisicoquimicaAdsorcionAtomica::count();
    $fqSecado = FisicoquimicaSecadoSuelos::count();
    $fqAdmin = FisicoquimicaAreaAdministrativa::count();
    $fqDeposito = FisicoquimicaDeposito::count();
    $fqBalanzas = FisicoquimicaAreaBalanzas::count();
    $fqLabAnalisis = FisicoquimicaLaboratorioAnalisis::count();
    $fqEquipos = FisicoquimicaAdsorcionAtomicaEquipo::count() 
                + FisicoquimicaSecadoSuelosEquipo::count()
                + FisicoquimicaDepositoEquipo::count()
                + FisicoquimicaAreaBalanzasEquipo::count()
                + FisicoquimicaLaboratorioAnalisisEquipo::count();
    $totalFisicoQuimica = $fqAdsorcion + $fqSecado + $fqAdmin + $fqDeposito + $fqBalanzas + $fqLabAnalisis + $fqEquipos;
    
    // Zoología
    $zooUtileria = ZoologiaUtileria::count();
    $zooVidrieria = ZoologiaVidrieria::count();
    $zooReactivos = ZoologiaReactivos::count();
    $totalZoologia = $zooUtileria + $zooVidrieria + $zooReactivos;
    
    // Microbiología
    $microUtileria = MicrobiologiaUtileria::count();
    $microVidrieria = MicrobiologiaVidrieria::count();
    $microReactivos = MicrobiologiaReactivos::count();
    $totalMicrobiologia = $microUtileria + $microVidrieria + $microReactivos;
    
    // Totales generales
    $totalGeneral = $totalItems + $totalBiotec + $totalFisicoQuimica + $totalZoologia + $totalMicrobiologia;
    $gestiones = Inventario::distinct('gestion')->count('gestion');
    
    // Porcentajes
    $goodPercentage = $totalItems > 0 ? round(($goodItems / $totalItems) * 100, 2) : 0;
    $badPercentage = $totalItems > 0 ? round(($badItems / $totalItems) * 100, 2) : 0;
    $regularPercentage = $totalItems > 0 ? round(($regularItems / $totalItems) * 100, 2) : 0;

    $stats = [
        'inventario' => [
            'total' => $totalItems,
            'bueno' => $goodItems,
            'regular' => $regularItems,
            'malo' => $badItems,
            'gestiones' => $gestiones,
        ],
        'biotecnologia' => [
            'total' => $totalBiotec,
            'utileria' => $biotecUtileria,
            'vidrieria' => $biotecVidrieria,
            'reactivos' => $biotecReactivos,
            'siembra' => $biotecSiembra,
            'incubacion' => $biotecIncubacion,
            'equipos' => $biotecEquipos,
        ],
        'fisicoquimica' => [
            'total' => $totalFisicoQuimica,
            'adsorcion' => $fqAdsorcion,
            'secado' => $fqSecado,
            'admin' => $fqAdmin,
            'deposito' => $fqDeposito,
            'balanzas' => $fqBalanzas,
            'lab_analisis' => $fqLabAnalisis,
            'equipos' => $fqEquipos,
        ],
        'zoologia' => [
            'total' => $totalZoologia,
            'utileria' => $zooUtileria,
            'vidrieria' => $zooVidrieria,
            'reactivos' => $zooReactivos,
        ],
        'microbiologia' => [
            'total' => $totalMicrobiologia,
            'utileria' => $microUtileria,
            'vidrieria' => $microVidrieria,
            'reactivos' => $microReactivos,
        ],
        'totales' => [
            'general' => $totalGeneral,
            'laboratorios' => 4,
            'modulos' => 24,
        ],
        'porcentajes' => [
            'bueno' => $goodPercentage,
            'regular' => $regularPercentage,
            'malo' => $badPercentage,
        ],
    ];

    // Items recientes (últimos 5)
    $recentItems = Inventario::orderBy('created_at', 'desc')->take(5)->get();
    
    // Estadísticas de tendencias (últimos 6 meses)
    $monthlyStats = [];
    for ($i = 5; $i >= 0; $i--) {
        $month = now()->subMonths($i);
        $monthStart = $month->copy()->startOfMonth();
        $monthEnd = $month->copy()->endOfMonth();
        
        $monthlyStats[] = [
            'label' => $month->format('M Y'),
            'inventario' => Inventario::whereBetween('created_at', [$monthStart, $monthEnd])->count(),
            'biotecnologia' => BiotecnologiaUtileria::whereBetween('created_at', [$monthStart, $monthEnd])->count()
                + BiotecnologiaVidrieria::whereBetween('created_at', [$monthStart, $monthEnd])->count()
                + BiotecnologiaReactivos::whereBetween('created_at', [$monthStart, $monthEnd])->count(),
        ];
    }
    
    // Items agregados hoy
    $itemsToday = Inventario::whereDate('created_at', today())->count();
    
    // Items agregados esta semana
    $itemsThisWeek = Inventario::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
    
    // Items agregados este mes
    $itemsThisMonth = Inventario::whereMonth('created_at', now()->month)
        ->whereYear('created_at', now()->year)
        ->count();
    
    // Valor total del inventario
    $totalValue = Inventario::sum('valor_adq') ?? 0;
    
    // Items que necesitan atención (estado malo)
    $itemsNeedingAttention = $badItems;
    
    // Top 5 módulos con más items
    $topModules = [
        ['name' => 'Inventario General', 'count' => $totalItems, 'route' => route('inventario.index'), 'icon' => 'fas fa-boxes', 'color' => '#3b82f6'],
        ['name' => 'Biotecnología', 'count' => $totalBiotec, 'route' => route('biotecnologia.index'), 'icon' => 'fas fa-seedling', 'color' => '#10b981'],
        ['name' => 'Físico Química', 'count' => $totalFisicoQuimica, 'route' => route('fisicoquimica.index'), 'icon' => 'fas fa-flask', 'color' => '#06b6d4'],
        ['name' => 'Zoología', 'count' => $totalZoologia, 'route' => route('zoologia.utileria.index'), 'icon' => 'fas fa-leaf', 'color' => '#f59e0b'],
        ['name' => 'Microbiología', 'count' => $totalMicrobiologia, 'route' => route('microbiologia.utileria.index'), 'icon' => 'fas fa-microscope', 'color' => '#8b5cf6'],
    ];
    usort($topModules, function($a, $b) {
        return $b['count'] - $a['count'];
    });
    $topModules = array_slice($topModules, 0, 5);

    return view('dashboard', compact(
        'stats', 
        'recentItems', 
        'goodPercentage',
        'monthlyStats',
        'itemsToday',
        'itemsThisWeek',
        'itemsThisMonth',
        'totalValue',
        'itemsNeedingAttention',
        'topModules'
    ));
}


    /**
     * Export inventory data to PDF
     */
    public function exportPDF()
    {
        // Configurar zona horaria de Colombia
        date_default_timezone_set('America/Bogota');
        
        // Retrieve all inventory items ordered by creation date
        $inventario = Inventario::orderBy('created_at', 'desc')->get();
        
        // Calculate summary statistics
        $stats = [
            'total_items' => $inventario->count(),
            'total_value' => $inventario->sum('valor_adq'),
            'estado_bueno' => $inventario->where('estado', 'bueno')->count(),
            'estado_regular' => $inventario->where('estado', 'regular')->count(),
            'estado_malo' => $inventario->where('estado', 'malo')->count(),
            'gestiones' => $inventario->groupBy('gestion')->count(),
        ];
        
        // Generate filename with current date
        $filename = 'inventario_completo_' . date('Y-m-d_His') . '.pdf';
        
        // Load PDF view and configure settings for card-based layout
        $pdf = PDF::loadView('inventario.pdf', compact('inventario', 'stats'))
                  ->setPaper('a4', 'portrait') // Portrait works better for card layout
                  ->setOptions([
                      'dpi' => 150,
                      'defaultFont' => 'DejaVu Sans',
                      'isHtml5ParserEnabled' => true,
                      'isRemoteEnabled' => false,
                      'debugKeepTemp' => false,
                      'enable_php' => true,
                      'isPhpEnabled' => true,
                      'isJavascriptEnabled' => false,
                  ]);
        
        // Return PDF download
        return $pdf->download($filename);
    }
    
    /**
     * Export inventory data to PDF by sections (for very large inventories)
     * This creates a paginated PDF that's easier to process
     */
    public function exportPDFPaginated(Request $request)
    {
        $perPage = $request->input('per_page', 50); // Items per page
        $page = $request->input('page', 1);
        
        // Get paginated inventory items
        $inventario = Inventario::orderBy('created_at', 'desc')
                                ->skip(($page - 1) * $perPage)
                                ->take($perPage)
                                ->get();
        
        // Calculate overall statistics (not just for this page)
        $allInventory = Inventario::all();
        $stats = [
            'total_items' => $allInventory->count(),
            'total_value' => $allInventory->sum('valor_adq'),
            'estado_bueno' => $allInventory->where('estado', 'bueno')->count(),
            'estado_regular' => $allInventory->where('estado', 'regular')->count(),
            'estado_malo' => $allInventory->where('estado', 'malo')->count(),
            'gestiones' => $allInventory->groupBy('gestion')->count(),
        ];
        
        // Add pagination info to stats
        $stats['current_page'] = $page;
        $stats['total_pages'] = ceil($stats['total_items'] / $perPage);
        $stats['showing_from'] = (($page - 1) * $perPage) + 1;
        $stats['showing_to'] = min($page * $perPage, $stats['total_items']);
        
        $filename = 'inventario_pagina_' . $page . '_' . date('Y-m-d') . '.pdf';
        
        $pdf = PDF::loadView('inventario.pdf', compact('inventario', 'stats'))
                  ->setPaper('a4', 'portrait')
                  ->setOptions([
                      'dpi' => 150,
                      'defaultFont' => 'DejaVu Sans',
                      'isHtml5ParserEnabled' => true,
                      'isRemoteEnabled' => false,
                      'isPhpEnabled' => true,
                      'isJavascriptEnabled' => false,
                  ]);
        
        return $pdf->download($filename);
    }

    /**
     * Export inventory data to Excel
     */
    public function exportExcel()
    {
        // Generate filename with current date and time
        $filename = 'inventario_' . date('Y-m-d_His') . '.xlsx';
        
        // Return Excel download
        return Excel::download(new InventarioExport, $filename);
    }
    
    /**
     * Preview PDF in browser (useful for testing)
     */
    public function previewPDF()
    {
        $inventario = Inventario::orderBy('created_at', 'desc')->get();
        
        $stats = [
            'total_items' => $inventario->count(),
            'total_value' => $inventario->sum('valor_adq'),
            'estado_bueno' => $inventario->where('estado', 'bueno')->count(),
            'estado_regular' => $inventario->where('estado', 'regular')->count(),
            'estado_malo' => $inventario->where('estado', 'malo')->count(),
            'gestiones' => $inventario->groupBy('gestion')->count(),
        ];
        
        $pdf = PDF::loadView('inventario.pdf', compact('inventario', 'stats'))
                  ->setPaper('a4', 'portrait')
                  ->setOptions([
                      'dpi' => 150,
                      'defaultFont' => 'DejaVu Sans',
                      'isHtml5ParserEnabled' => true,
                      'isRemoteEnabled' => false,
                      'isPhpEnabled' => true,
                      'isJavascriptEnabled' => false,
                  ]);
        
        // Stream instead of download for preview
        return $pdf->stream('inventario_preview.pdf');
    }
}