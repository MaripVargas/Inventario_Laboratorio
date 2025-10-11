<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Inventario - {{ now()->timezone('America/Bogota')->format('d/m/Y') }}</title>
    <style>
        @page {
            margin: 12mm 10mm;
            size: A4;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 9px;
            color: #2c3e50;
            background: #f8f9fa;
        }
        
        .header {
            text-align: center;
            padding: 15px;
            background-color: #0066CC;
            color: #FFFFFF;
            border-radius: 8px;
            margin-bottom: 15px;
            border: 3px solid #004C99;
        }
        
        .header h1 {
            font-size: 24px;
            margin-bottom: 5px;
            font-weight: bold;
            letter-spacing: 1px;
            color: #FFFFFF;
        }
        
        .header p {
            font-size: 11px;
            color: #FFFFFF;
        }
        
        .summary-grid {
            display: table;
            width: 100%;
            margin-bottom: 15px;
            border-spacing: 8px;
        }
        
        .summary-row {
            display: table-row;
        }
        
        .summary-card {
            display: table-cell;
            background: white;
            border-left: 4px solid #4A90E2;
            border-radius: 6px;
            padding: 12px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .summary-card h3 {
            font-size: 9px;
            color: #6c757d;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .summary-card .value {
            font-size: 18px;
            font-weight: bold;
            color: #2c3e50;
        }
        
        .summary-card .value.currency {
            color: #28a745;
            font-size: 16px;
        }
        
        .items-grid {
            display: table;
            width: 100%;
            border-spacing: 10px;
        }
        
        .item-row {
            display: table-row;
        }
        
        .item-card {
            display: table-cell;
            width: 48%;
            background: white;
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.12);
            border-top: 3px solid #4A90E2;
            page-break-inside: avoid;
        }
        
        .item-header {
            display: table;
            width: 100%;
            margin-bottom: 10px;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 8px;
        }
        
        .item-image-container {
            display: table-cell;
            width: 70px;
            vertical-align: top;
            padding-right: 10px;
        }
        
        .item-image {
            width: 65px;
            height: 65px;
            object-fit: cover;
            border-radius: 6px;
            border: 2px solid #e9ecef;
        }
        
        .no-image {
            width: 65px;
            height: 65px;
            background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8px;
            color: #6c757d;
            text-align: center;
            border: 2px solid #dee2e6;
        }
        
        .item-main-info {
            display: table-cell;
            vertical-align: top;
        }
        
        .item-title {
            font-size: 11px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 3px;
        }
        
        .item-subtitle {
            font-size: 9px;
            color: #6c757d;
            margin-bottom: 5px;
        }
        
        .item-badge-container {
            margin-top: 5px;
        }
        
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 7px;
            font-weight: bold;
            text-transform: uppercase;
            margin-right: 5px;
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
            margin-top: 8px;
        }
        
        .detail-row {
            display: table-row;
        }
        
        .detail-label {
            display: table-cell;
            font-size: 8px;
            color: #6c757d;
            padding: 3px 5px 3px 0;
            font-weight: bold;
            width: 35%;
        }
        
        .detail-value {
            display: table-cell;
            font-size: 9px;
            color: #2c3e50;
            padding: 3px 0;
        }
        
        .detail-value.highlight {
            font-weight: bold;
            color: #4A90E2;
        }
        
        .detail-value.currency {
            font-weight: bold;
            color: #28a745;
            font-size: 10px;
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
            font-size: 8px;
            color: #6c757d;
            padding: 8px;
            background: white;
            border-top: 2px solid #4A90E2;
        }
        
        .section-divider {
            height: 2px;
            background: linear-gradient(90deg, #4A90E2 0%, #0066CC 100%);
            margin: 15px 0;
            border-radius: 2px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>📦 REPORTE DE INVENTARIO</h1>
        <p>Laboratorio - Generado el {{ date('d/m/Y H:i:s') }}</p>
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
        </div>
        <div class="summary-row">
            <div class="summary-card">
                <h3>Estado Regular</h3>
                <div class="value">{{ number_format($stats['estado_regular']) }}</div>
            </div>
            <div class="summary-card">
                <h3>Estado Malo</h3>
                <div class="value">{{ number_format($stats['estado_malo']) }}</div>
            </div>
            <div class="summary-card">
                <h3>Gestiones</h3>
                <div class="value">{{ number_format($stats['gestiones']) }}</div>
            </div>
        </div>
    </div>
    
    <div class="section-divider"></div>
    
    <!-- Items Grid -->
    @if($inventario->isNotEmpty())
        @foreach($inventario->chunk(2) as $chunkIndex => $chunk)
            <div class="items-grid">
                <div class="item-row">
                    @foreach($chunk as $item)
                    <div class="item-card">
                        <!-- Item Header with Image -->
                        <div class="item-header">
                            <div class="item-image-container">
                                @if($item->foto && file_exists(public_path('uploads/inventario/' . $item->foto)))
                                    @php
                                        $imagePath = public_path('uploads/inventario/' . $item->foto);
                                        $imageData = base64_encode(file_get_contents($imagePath));
                                        $imageType = pathinfo($imagePath, PATHINFO_EXTENSION);
                                        $imageSrc = 'data:image/' . $imageType . ';base64,' . $imageData;
                                    @endphp
                                    <img src="{{ $imageSrc }}" alt="Item" class="item-image">
                                @else
                                    <div class="no-image">Sin Imagen</div>
                                @endif
                            </div>
                            <div class="item-main-info">
                                <div class="item-title">{{ Str::limit($item->desc_sku, 40) }}</div>
                                <div class="item-subtitle">{{ Str::limit($item->descripcion_elemento, 50) }}</div>
                                <div class="item-badge-container">
                                    <span class="badge badge-primary">ID: {{ $item->id }}</span>
                                    <span class="badge badge-primary">Placa: {{ $item->no_placa }}</span>
                                    @if($item->estado == 'bueno')
                                        <span class="badge badge-success">{{ strtoupper($item->estado) }}</span>
                                    @elseif($item->estado == 'regular')
                                        <span class="badge badge-warning">{{ strtoupper($item->estado) }}</span>
                                    @else
                                        <span class="badge badge-danger">{{ strtoupper($item->estado) }}</span>
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
                                <div class="detail-label">Regional:</div>
                                <div class="detail-value">{{ $item->cod_regional ?? 'N/A' }}</div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">Centro:</div>
                                <div class="detail-value">{{ $item->cod_centro ?? 'N/A' }}</div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">Almacén:</div>
                                <div class="detail-value">{{ Str::limit($item->desc_almacen ?? 'N/A', 25) }}</div>
                            </div>
                            @if($item->consecutivo)
                            <div class="detail-row">
                                <div class="detail-label">Consecutivo:</div>
                                <div class="detail-value">{{ $item->consecutivo }}</div>
                            </div>
                            @endif
                            @if($item->serial)
                            <div class="detail-row">
                                <div class="detail-label">Serial:</div>
                                <div class="detail-value">{{ $item->serial }}</div>
                            </div>
                            @endif
                            @if($item->atributos)
                            <div class="detail-row">
                                <div class="detail-label">Atributos:</div>
                                <div class="detail-value">{{ Str::limit($item->atributos, 30) }}</div>
                            </div>
                            @endif
                            <div class="detail-row">
                                <div class="detail-label">Fecha Adquisición:</div>
                                <div class="detail-value">{{ $item->fecha_adq ? $item->fecha_adq->format('d/m/Y') : 'N/A' }}</div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">Valor Adquisición:</div>
                                <div class="detail-value currency">${{ number_format($item->valor_adq, 0, ',', '.') }} COP</div>
                            </div>
                            @if($item->gestion)
                            <div class="detail-row">
                                <div class="detail-label">Gestión:</div>
                                <div class="detail-value">{{ Str::limit($item->gestion, 30) }}</div>
                            </div>
                            @endif
                            @if($item->acciones)
                            <div class="detail-row">
                                <div class="detail-label">Acciones:</div>
                                <div class="detail-value">{{ Str::limit($item->acciones, 30) }}</div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                    
                    @if($chunk->count() == 1)
                        <div class="item-card" style="visibility: hidden;"></div>
                    @endif
                </div>
            </div>
            
            @if(($chunkIndex + 1) % 3 == 0 && !$loop->last)
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
        <p><strong>Sistema de Inventario del Laboratorio</strong> | Generado: {{ date('d/m/Y H:i:s') }} | Total de registros: {{ $stats['total_items'] }}</p>
    </div>
</body>
</html>