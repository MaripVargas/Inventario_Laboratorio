<?php

namespace App\Exports;

use App\Exports\Concerns\HasDefaultSheetStyling;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;

class BiotecnologiaReactivosExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithEvents
{
    use HasDefaultSheetStyling;

    protected Collection $items;

    public function __construct(Collection $items)
    {
        $this->items = $items;
    }

    public function collection(): Collection
    {
        return $this->items->map(function ($item) {
            return [
                'Nombre del reactivo' => $item->nombre_reactivo,
                'Cantidad' => $item->cantidad,
                'Unidad' => $item->unidad,
                'Concentración' => $item->concentracion,
                'Detalle' => $item->detalle,
                'Fecha de registro' => optional($item->created_at)->format('d/m/Y H:i'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nombre del reactivo',
            'Cantidad',
            'Unidad',
            'Concentración',
            'Detalle',
            'Fecha de registro',
        ];
    }

}

