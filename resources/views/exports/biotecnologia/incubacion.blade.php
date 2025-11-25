<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte Incubación Biotecnología</title>
    <style>
        body { font-family: 'DejaVu Sans', Arial, sans-serif; font-size: 10px; color: #111827; }
        h1 { text-align: center; margin-bottom: 8px; }
        p.meta { text-align: center; font-size: 9px; color: #6b7280; margin-top: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border: 1px solid #d1d5db; padding: 4px 6px; }
        th { background: #f3f4f6; text-transform: uppercase; font-size: 9px; }
        tbody tr:nth-child(even) { background: #f9fafb; }
    </style>
</head>
<body>
    <h1>Incubación - Laboratorio de Biotecnología</h1>
    <p class="meta">Generado el {{ $generatedAt->format('d/m/Y H:i') }} | Total de registros: {{ $items->count() }}</p>

    <table>
        <thead>
            <tr>
                <th>IR ID</th>
                <th>IV ID</th>
                <th>Cód. Regional</th>
                <th>Cód. Centro</th>
                <th>Desc. Almacén</th>
                <th>No. Placa</th>
                <th>Consecutivo</th>
                <th>Desc. SKU</th>
                <th>Descripción</th>
                <th>Atributos</th>
                <th>Serial</th>
                <th>Fecha Adq.</th>
                <th>Valor</th>
                <th>Estado</th>
                <th>Tipo</th>
                <th>Gestión</th>
                <th>Uso</th>
                <th>Contrato</th>
                <th>Responsable</th>
                <th>Cédula</th>
                <th>Vinculación</th>
                <th>Usuario</th>
                <th>Fecha Registro</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                <tr>
                    <td>{{ $item->ir_id }}</td>
                    <td>{{ $item->iv_id ?? '-' }}</td>
                    <td>{{ $item->cod_regional ?? '-' }}</td>
                    <td>{{ $item->cod_centro ?? '-' }}</td>
                    <td>{{ $item->desc_almacen ?? '-' }}</td>
                    <td>{{ $item->no_placa ?? '-' }}</td>
                    <td>{{ $item->consecutivo ?? '-' }}</td>
                    <td>{{ $item->desc_sku ?? '-' }}</td>
                    <td>{{ $item->descripcion_elemento ?? '-' }}</td>
                    <td>{{ $item->atributos ?? '-' }}</td>
                    <td>{{ $item->serial ?? '-' }}</td>
                    <td>{{ optional($item->fecha_adq)->format('d/m/Y') ?? '-' }}</td>
                    <td>${{ number_format($item->valor_adq, 2) }}</td>
                    <td>{{ ucfirst($item->estado) }}</td>
                    <td>{{ $item->tipo_material ?? '-' }}</td>
                    <td>{{ $item->gestion ?? '-' }}</td>
                    <td>{{ $item->uso ?? '-' }}</td>
                    <td>{{ $item->contrato ?? '-' }}</td>
                    <td>{{ $item->nombre_responsable ?? '-' }}</td>
                    <td>{{ $item->cedula ?? '-' }}</td>
                    <td>{{ $item->vinculacion ?? '-' }}</td>
                    <td>{{ $item->usuario_registra ?? '-' }}</td>
                    <td>{{ optional($item->created_at)->format('d/m/Y H:i') ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

