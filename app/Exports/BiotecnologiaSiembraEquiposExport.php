<?php

namespace App\Exports;

use App\Exports\Concerns\HasDefaultSheetStyling;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class BiotecnologiaSiembraEquiposExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithEvents, WithColumnFormatting
{
    use HasDefaultSheetStyling;

    protected Collection $items;

    public function __construct(Collection $items)
    {
        $this->items = $items;
    }

    public function collection(): Collection
    {
        return $this->items->map(function ($item, $index) {
            return [
                'Ítem #' => $index + 1,
                'Nombre' => $item->nombre,
                'Cantidad' => $item->cantidad,
                'Unidad' => $item->unidad,
                'Detalle' => $item->detalle,
                'No. Placa' => $item->no_placa,
                'Fecha Adq.' => optional($item->fecha_adq)->format('d/m/Y'),
                'Valor' => $item->valor,
                'Responsable' => $item->nombre_responsable,
                'Cédula' => $item->cedula,
                'Vinculación' => $item->vinculacion,
                'Fecha Registro' => optional($item->fecha_registro)->format('d/m/Y'),
                'Usuario Registra' => $item->usuario_registra,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Ítem #',
            'Nombre',
            'Cantidad',
            'Unidad',
            'Detalle',
            'No. Placa',
            'Fecha Adq.',
            'Valor',
            'Responsable',
            'Cédula',
            'Vinculación',
            'Fecha Registro',
            'Usuario Registra',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'H' => NumberFormat::FORMAT_CURRENCY_USD_SIMPLE,
        ];
    }
}

