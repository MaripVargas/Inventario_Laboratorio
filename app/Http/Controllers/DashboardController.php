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
        // Retrieve all inventory items
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
        $filename = 'inventario_' . date('Y-m-d') . '.pdf';
        
        // Load PDF view and configure settings
        $pdf = PDF::loadView('inventario.pdf', compact('inventario', 'stats'))
                  ->setPaper('a4', 'landscape')
                  ->setOptions([
                      'defaultFont' => 'Arial',
                      'isHtml5ParserEnabled' => true,
                      'isRemoteEnabled' => true,
                      'isPhpEnabled' => true,
                      'isFontSubsettingEnabled' => true,
                      'defaultMediaType' => 'print',
                  ]);
        
        // Return PDF download
        return $pdf->download($filename);
    }

    /**
     * Export inventory data to Excel
     */
    public function exportExcel()
    {
        // Generate filename with current date
        $filename = 'inventario_' . date('Y-m-d') . '.xlsx';
        
        // Return Excel download
        return Excel::download(new InventarioExport, $filename);
    }
}
