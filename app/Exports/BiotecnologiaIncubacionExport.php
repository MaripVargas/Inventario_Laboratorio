<?php

namespace App\Exports;

use App\Exports\Concerns\HasDefaultSheetStyling;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;

class BiotecnologiaIncubacionExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithEvents
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
                'IR ID' => $item->ir_id,
                'IV ID' => $item->iv_id,
                'Código regional' => $item->cod_regional,
                'Código centro' => $item->cod_centro,
                'Desc. almacén' => $item->desc_almacen,
                'No. placa' => $item->no_placa,
                'Consecutivo' => $item->consecutivo,
                'Descripción SKU' => $item->desc_sku,
                'Descripción completa' => $item->descripcion_elemento,
                'Atributos' => $item->atributos,
                'Serial' => $item->serial,
                'Fecha adquisición' => optional($item->fecha_adq)->format('d/m/Y'),
                'Valor adquisición' => $item->valor_adq,
                'Estado' => $item->estado,
                'Tipo de material' => $item->tipo_material,
                'Gestión' => $item->gestion,
                'Uso' => $item->uso,
                'Contrato' => $item->contrato,
                'Responsable' => $item->nombre_responsable,
                'Cédula' => $item->cedula,
                'Vinculación' => $item->vinculacion,
                'Usuario registra' => $item->usuario_registra,
                'Fecha registro' => optional($item->created_at)->format('d/m/Y H:i'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'IR ID',
            'IV ID',
            'Código regional',
            'Código centro',
            'Desc. almacén',
            'No. placa',
            'Consecutivo',
            'Descripción SKU',
            'Descripción completa',
            'Atributos',
            'Serial',
            'Fecha adquisición',
            'Valor adquisición',
            'Estado',
            'Tipo de material',
            'Gestión',
            'Uso',
            'Contrato',
            'Responsable',
            'Cédula',
            'Vinculación',
            'Usuario registra',
            'Fecha registro',
        ];
    }

}

