<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Inventario - {{ date('d/m/Y') }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 9px;
            line-height: 1.3;
            color: #333;
            background: white;
        }
        
        .header {
            text-align: center;
            margin-bottom: 15px;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 6px;
        }
        
        .header h1 {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 4px;
        }
        
        .header p {
            font-size: 10px;
            opacity: 0.9;
        }
        
        .summary {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }
        
        .summary-card {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            padding: 8px;
            margin: 3px;
            flex: 1;
            min-width: 100px;
            text-align: center;
        }
        
        .summary-card h3 {
            font-size: 9px;
            color: #6c757d;
            margin-bottom: 3px;
        }
        
        .summary-card .value {
            font-size: 12px;
            font-weight: bold;
            color: #495057;
        }
        
        .summary-card .value.currency {
            color: #28a745;
        }
        
        .table-container {
            margin-top: 15px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 7px;
        }
        
        th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 6px 3px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #5a6fd8;
            font-size: 7px;
        }
        
        td {
            padding: 4px 3px;
            border: 1px solid #dee2e6;
            vertical-align: top;
            font-size: 7px;
        }
        
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        .estado-badge {
            padding: 1px 4px;
            border-radius: 8px;
            font-size: 6px;
            font-weight: bold;
            text-transform: uppercase;
            display: inline-block;
        }
        
        .estado-bueno {
            background-color: #d4edda;
            color: #155724;
        }
        
        .estado-regular {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .estado-malo {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .currency {
            text-align: right;
            font-weight: bold;
            color: #28a745;
        }
        
        .date {
            text-align: center;
        }
        
        .text-center {
            text-align: center;
        }
        
        .text-right {
            text-align: right;
        }
        
        .font-bold {
            font-weight: bold;
        }
        
        .item-image {
            width: 25px;
            height: 25px;
            object-fit: cover;
            border-radius: 2px;
            border: 1px solid #dee2e6;
            display: block;
            margin: 0 auto;
        }
        
        .no-image {
            width: 25px;
            height: 25px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 2px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 5px;
            color: #6c757d;
            margin: 0 auto;
        }
        
        /* Additional professional styling */
        .table-header-row {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .data-row:hover {
            background-color: #f1f3f4;
        }
        
        .important-field {
            font-weight: bold;
            color: #2c3e50;
        }
        
        .secondary-field {
            color: #6c757d;
        }
        
        .footer {
            position: fixed;
            bottom: 15px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 7px;
            color: #6c757d;
            border-top: 1px solid #dee2e6;
            padding-top: 8px;
        }
        
        .page-break {
            page-break-before: always;
        }
        
        /* Column widths for better organization - All fields included */
        .col-imagen { width: 3%; }
        .col-id { width: 4%; }
        .col-ir-id { width: 4%; }
        .col-iv-id { width: 4%; }
        .col-regional { width: 4%; }
        .col-centro { width: 4%; }
        .col-almacen { width: 6%; }
        .col-placa { width: 5%; }
        .col-consecutivo { width: 4%; }
        .col-sku { width: 6%; }
        .col-serial { width: 4%; }
        .col-desc { width: 12%; }
        .col-atributos { width: 8%; }
        .col-fecha { width: 5%; }
        .col-valor { width: 6%; }
        .col-gestion { width: 6%; }
        .col-acciones { width: 6%; }
        .col-estado { width: 4%; }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>REPORTE DE INVENTARIO</h1>
        <p>Laboratorio - Generado el {{ date('d/m/Y H:i:s') }}</p>
    </div>
    
    <!-- Summary Statistics -->
    <div class="summary">
        <div class="summary-card">
            <h3>Total Items</h3>
            <div class="value">{{ number_format($stats['total_items']) }}</div>
        </div>
        <div class="summary-card">
            <h3>Valor Total</h3>
            <div class="value currency">${{ number_format($stats['total_value'], 0, ',', '.') }} COP</div>
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
        <div class="summary-card">
            <h3>Gestiones</h3>
            <div class="value">{{ number_format($stats['gestiones']) }}</div>
        </div>
    </div>
    
    <!-- Inventory Table -->
    <div class="table-container">
        <table>
            <thead>
                <tr class="table-header-row">
                    <th class="col-imagen text-center">Imagen</th>
                    <th class="col-id">ID</th>
                    <th class="col-ir-id">IR ID</th>
                    <th class="col-iv-id">IV ID</th>
                    <th class="col-regional">Cód. Regional</th>
                    <th class="col-centro">Cód. Centro</th>
                    <th class="col-almacen">Desc. Almacén</th>
                    <th class="col-placa">No. Placa</th>
                    <th class="col-consecutivo">Consecutivo</th>
                    <th class="col-sku">Desc. SKU</th>
                    <th class="col-serial">Serial</th>
                    <th class="col-desc">Descripción Completa</th>
                    <th class="col-atributos">Atributos</th>
                    <th class="col-fecha text-center">Fecha Adq.</th>
                    <th class="col-valor text-right">Valor Adq.</th>
                    <th class="col-gestion">Gestión</th>
                    <th class="col-acciones">Acciones</th>
                    <th class="col-estado text-center">Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($inventario as $item)
                <tr class="data-row">
                    <td class="text-center">
                        @if($item->foto && file_exists(public_path('uploads/inventario/' . $item->foto)))
                            @php
                                $imagePath = public_path('uploads/inventario/' . $item->foto);
                                $imageData = base64_encode(file_get_contents($imagePath));
                                $imageType = pathinfo($imagePath, PATHINFO_EXTENSION);
                                $imageSrc = 'data:image/' . $imageType . ';base64,' . $imageData;
                            @endphp
                            <img src="{{ $imageSrc }}" alt="Imagen del item" class="item-image">
                        @else
                            <div class="no-image">Sin imagen</div>
                        @endif
                    </td>
                    <td class="important-field">{{ $item->id }}</td>
                    <td class="important-field">{{ $item->ir_id }}</td>
                    <td class="important-field">{{ $item->iv_id ?? 'N/A' }}</td>
                    <td class="secondary-field">{{ $item->cod_regional ?? 'N/A' }}</td>
                    <td class="secondary-field">{{ $item->cod_centro ?? 'N/A' }}</td>
                    <td>{{ Str::limit($item->desc_almacen ?? 'N/A', 15) }}</td>
                    <td class="important-field">{{ $item->no_placa }}</td>
                    <td class="secondary-field">{{ $item->consecutivo ?? 'N/A' }}</td>
                    <td>{{ $item->desc_sku }}</td>
                    <td class="secondary-field">{{ $item->serial ?? 'N/A' }}</td>
                    <td>{{ Str::limit($item->descripcion_elemento, 30) }}</td>
                    <td>{{ Str::limit($item->atributos ?? 'N/A', 20) }}</td>
                    <td class="date">{{ $item->fecha_adq ? $item->fecha_adq->format('d/m/Y') : 'N/A' }}</td>
                    <td class="currency">${{ number_format($item->valor_adq, 0, ',', '.') }}</td>
                    <td class="secondary-field">{{ $item->gestion ?? 'N/A' }}</td>
                    <td>{{ Str::limit($item->acciones ?? 'N/A', 15) }}</td>
                    <td class="text-center">
                        <span class="estado-badge estado-{{ $item->estado }}">
                            {{ ucfirst($item->estado) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="18" class="text-center">No hay elementos en el inventario</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Footer -->
    <div class="footer">
        <p>Página 1 de 1 | Sistema de Inventario del Laboratorio | {{ date('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html>
