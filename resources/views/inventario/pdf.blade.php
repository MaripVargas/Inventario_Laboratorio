<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Inventario - {{ now()->timezone('America/Bogota')->format('d/m/Y') }}</title>
    <style>
        @page {
            margin: 10mm 8mm;
            size: A4;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 8px;
            color: #2c3e50;
            background: #f8f9fa;
        }
        
        .header {
            text-align: center;
            padding: 10px;
            background-color: #0066CC;
            color: #FFFFFF;
            border-radius: 6px;
            margin-bottom: 10px;
            border: 2px solid #004C99;
        }
        
        .header h1 {
            font-size: 18px;
            margin-bottom: 3px;
            font-weight: bold;
            letter-spacing: 0.5px;
            color: #FFFFFF;
        }
        
        .header p {
            font-size: 9px;
            color: #FFFFFF;
        }
        
        .summary-grid {
            display: table;
            width: 100%;
            margin-bottom: 10px;
            border-spacing: 5px;
        }
        
        .summary-row {
            display: table-row;
        }
        
        .summary-card {
            display: table-cell;
            background: white;
            border-left: 3px solid #4A90E2;
            border-radius: 4px;
            padding: 8px;
            text-align: center;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .summary-card h3 {
            font-size: 7px;
            color: #6c757d;
            margin-bottom: 3px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        
        .summary-card .value {
            font-size: 14px;
            font-weight: bold;
            color: #2c3e50;
        }
        
        .summary-card .value.currency {
            color: #28a745;
            font-size: 12px;
        }
        
        .items-grid {
            display: table;
            width: 100%;
            border-spacing: 6px;
        }
        
        .item-row {
            display: table-row;
        }
        
        .item-card {
            display: table-cell;
            width: 32%;
            background: white;
            border-radius: 6px;
            padding: 7px;
            margin-bottom: 6px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.1);
            border-top: 2px solid #4A90E2;
            page-break-inside: avoid;
        }
        
        .item-header {
            display: table;
            width: 100%;
            margin-bottom: 6px;
            border-bottom: 1px solid #e9ecef;
            padding-bottom: 4px;
        }
        
        .item-image-container {
            display: table-cell;
            width: 50px;
            vertical-align: top;
            padding-right: 6px;
        }
        
        .item-image {
            width: 48px;
            height: 48px;
            object-fit: cover;
            border-radius: 4px;
            border: 1px solid #e9ecef;
        }
        
        .no-image {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 6px;
            color: #6c757d;
            text-align: center;
            border: 1px solid #dee2e6;
        }
        
        .item-main-info {
            display: table-cell;
            vertical-align: top;
        }
        
        .item-title {
            font-size: 8px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 1px;
        }
        
        .item-subtitle {
            font-size: 7px;
            color: #6c757d;
            margin-bottom: 2px;
        }
        
        .item-badge-container {
            margin-top: 2px;
        }
        
        .badge {
            display: inline-block;
            padding: 1px 4px;
            border-radius: 8px;
            font-size: 5px;
            font-weight: bold;
            text-transform: uppercase;
            margin-right: 2px;
            margin-bottom: 1px;
        }
        
        .badge-primary {
            background: #e7f3ff;
            color: #0056b3;
        }
        
        .badge-success {
            background: #d4edda;
            color: #155724;
        }
        
        .badge-warning {
            background: #fff3cd;
            color: #856404;
        }
        
        .badge-danger {
            background: #f8d7da;
            color: #721c24;
        }
        
        .item-details {
            display: table;
            width: 100%;
            margin-top: 5px;
        }
        
        .detail-row {
            display: table-row;
        }
        
        .detail-label {
            display: table-cell;
            font-size: 7px;
            color: #6c757d;
            padding: 1px 3px 1px 0;
            font-weight: bold;
            width: 40%;
        }
        
        .detail-value {
            display: table-cell;
            font-size: 7px;
            color: #2c3e50;
            padding: 1px 0;
        }
        
        .detail-value.highlight {
            font-weight: bold;
            color: #4A90E2;
        }
        
        .detail-value.currency {
            font-weight: bold;
            color: #28a745;
            font-size: 7px;
        }
        
        .page-break {
            page-break-after: always;
        }
        
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 7px;
            color: #6c757d;
            padding: 5px;
            background: white;
            border-top: 1px solid #4A90E2;
        }
        
        .section-divider {
            height: 1px;
            background: linear-gradient(90deg, #4A90E2 0%, #0066CC 100%);
            margin: 8px 0;
            border-radius: 1px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>REPORTE DE INVENTARIO</h1>
        <p>Generado el {{ date('d/m/Y H:i:s') }}</p>
    </div>
    
    <!-- Summary Statistics -->
    <div class="summary-grid">
        <div class="summary-row">
            <div class="summary-card">
                <h3>Total Items</h3>
                <div class="value">{{ number_format($stats['total_items']) }}</div>
            </div>
            <div class="summary-card">
                <h3>Valor Total</h3>
                <div class="value currency">${{ number_format($stats['total_value'], 0, ',', '.') }}</div>
            </div>
            <div class="summary-card">
                <h3>Estado Bueno</h3>
                <div class="value">{{ number_format($stats['estado_bueno']) }}</div>
            </div>
            <div class="summary-card">
                <h3>Estado Regular</h3>
                <div class="value">{{ number_format($stats['estado_regular']) }}</div>
            </div>
            <div class="summary-card">
                <h3>Estado Malo</h3>
                <div class="value">{{ number_format($stats['estado_malo']) }}</div>
            </div>
        </div>
    </div>
    
    <div class="section-divider"></div>
    
    <!-- Items Grid -->
    @if($inventario->isNotEmpty())
        @foreach($inventario->chunk(3) as $chunkIndex => $chunk)
            <div class="items-grid">
                <div class="item-row">
                    @foreach($chunk as $item)
                    <div class="item-card">
                        <!-- Item Header with Image -->
                        <div class="item-header">
                            <div class="item-image-container">
                               @if($item->foto && file_exists(public_path('uploads/inventario/' . $item->foto)))
                                    <img src="{{ public_path('uploads/inventario/' . $item->foto) }}" class="item-image">
                                @else
                                    <div class="no-image">Sin Imagen</div>
                                @endif
                            </div>
                            <div class="item-main-info">
                                <div class="item-title">{{ Str::limit($item->desc_sku, 25) }}</div>
                                <div class="item-subtitle">{{ Str::limit($item->descripcion_elemento, 35) }}</div>
                                <div class="item-badge-container">
                                    <span class="badge badge-primary">ID: {{ $item->id }}</span>
                                    @if($item->estado == 'bueno')
                                        <span class="badge badge-success">OK</span>
                                    @elseif($item->estado == 'regular')
                                        <span class="badge badge-warning">REG</span>
                                    @else
                                        <span class="badge badge-danger">MAL</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <!-- Item Details -->
                        <div class="item-details">
                            <div class="detail-row">
                                <div class="detail-label">IR ID:</div>
                                <div class="detail-value highlight">{{ $item->ir_id }}</div>
                            </div>
                            @if($item->iv_id)
                            <div class="detail-row">
                                <div class="detail-label">IV ID:</div>
                                <div class="detail-value">{{ $item->iv_id }}</div>
                            </div>
                            @endif
                            <div class="detail-row">
                                <div class="detail-label">Placa:</div>
                                <div class="detail-value">{{ $item->no_placa }}</div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">Responsable:</div>
                                <div class="detail-value">{{ Str::limit($item->nombre_responsable ?? 'N/A', 15) }}</div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">Cédula:</div>
                                <div class="detail-value">{{ $item->cedula ?? 'N/A' }}</div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">Vinculación:</div>
                                <div class="detail-value">{{ str_replace('_', ' ', ucfirst($item->vinculacion ?? 'N/A')) }}</div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">Regional:</div>
                                <div class="detail-value">{{ $item->cod_regional ?? 'N/A' }}</div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">Centro:</div>
                                <div class="detail-value">{{ $item->cod_centro ?? 'N/A' }}</div>
                            </div>
                            @if($item->serial)
                            <div class="detail-row">
                                <div class="detail-label">Serial:</div>
                                <div class="detail-value">{{ Str::limit($item->serial, 15) }}</div>
                            </div>
                            @endif
                            <div class="detail-row">
                                <div class="detail-label">Uso:</div>
                                <div class="detail-value">{{ str_replace('_', ' ', ucfirst($item->uso ?? 'N/A')) }}</div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">Contrato:</div>
                                <div class="detail-value">{{ Str::limit($item->contrato ?? 'N/A', 12) }}</div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">Fecha Adq:</div>
                                <div class="detail-value">{{ $item->fecha_adq ? $item->fecha_adq->format('d/m/Y') : 'N/A' }}</div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">Valor:</div>
                                <div class="detail-value currency">${{ number_format($item->valor_adq, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                    @if($chunk->count() < 3)
                        @for($i = 0; $i < 3 - $chunk->count(); $i++)
                            <div class="item-card" style="visibility: hidden;"></div>
                        @endfor
                    @endif
                </div>
            </div>
            
            @if(($chunkIndex + 1) % 2 == 0 && !$loop->last)
                <div class="page-break"></div>
            @endif
        @endforeach
    @else
        <div style="text-align: center; padding: 40px; color: #6c757d;">
            <p style="font-size: 14px;">No hay elementos en el inventario</p>
        </div>
    @endif
    
    <!-- Footer -->
    <div class="footer">
        <p><strong>Sistema de Inventario</strong> | Generado: {{ date('d/m/Y H:i:s') }} | Total: {{ $stats['total_items'] }} registros</p>
    </div>
</body>
</html>