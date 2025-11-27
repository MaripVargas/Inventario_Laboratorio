<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte Laboratorio de Análisis - Físico Química</title>
    <style>
        body { font-family: 'DejaVu Sans', Arial, sans-serif; font-size: 12px; color: #111827; }
        h1 { text-align: center; margin-bottom: 10px; }
        p.meta { text-align: center; font-size: 10px; color: #6b7280; margin-top: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #d1d5db; padding: 6px 8px; }
        th { background: #f3f4f6; text-transform: uppercase; font-size: 11px; }
        tbody tr:nth-child(even) { background: #f9fafb; }
    </style>
</head>
<body>
    <h1>Laboratorio de Análisis - Lab. Físico Química</h1>
    <p class="meta">Generado el {{ $generatedAt->format('d/m/Y H:i') }} | Total de registros: {{ $items->count() }}</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre del artículo</th>
                <th>Cantidad</th>
                <th>Unidad</th>
                <th>Detalle</th>
                <th>Fecha de registro</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->nombre_item }}</td>
                    <td>{{ $item->cantidad ?? '-' }}</td>
                    <td>{{ $item->unidad ?? '-' }}</td>
                    <td>{{ $item->detalle ?? '-' }}</td>
                    <td>{{ optional($item->created_at)->format('d/m/Y H:i') ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

