<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventario;
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
        $stats = [
            'total_items' => Inventario::count(),
            'gestiones' => Inventario::distinct('gestion')->count('gestion'),
            'estado_malo' => Inventario::where('estado', 'malo')->count(),
        ];
        
        // Obtener todos los items del inventario para mostrar en la tabla
        $inventario = Inventario::orderBy('created_at', 'desc')->get();
        
        return view('dashboard', compact('stats', 'inventario'));
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