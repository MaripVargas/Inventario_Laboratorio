<?php

namespace App\Exports;

use App\Models\Inventario;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class InventarioExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths, WithEvents, WithDrawings
{
    private $modulo;

    public function __construct($modulo = null)
    {
        $this->modulo = $modulo;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = Inventario::orderBy('created_at', 'desc');
        
        if ($this->modulo) {
            $query->where('lab_module', $this->modulo);
        }
        
        return $query->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Imagen',
            'ID',
            'IR ID',
            'IV ID',
            'Código Regional',
            'Código Centro',
            'Descripción Almacén',
            'No. Placa',
            'Consecutivo',
            'Desc. SKU',
            'Serial',
            'Descripción Completa',
            'Atributos',
            'Fecha Adquisición',
            'Valor Adquisición (COP)',
            'Gestión',
            'Acciones',
            'Estado',
            'Uso',
            'Contrato/PCN',
            'Responsable',
            'Cédula',
            'Vinculación',
            'Fecha Creación',
            'Fecha Actualización'
        ];
    }

    /**
     * @param mixed $inventario
     * @return array
     */
    public function map($inventario): array
    {
        return [
            $inventario->foto ? 'Imagen disponible' : 'Sin imagen', // Placeholder para la imagen
            $inventario->id,
            $inventario->ir_id,
            $inventario->iv_id ?? 'N/A',
            $inventario->cod_regional ?? 'N/A',
            $inventario->cod_centro ?? 'N/A',
            $inventario->desc_almacen ?? 'N/A',
            $inventario->no_placa,
            $inventario->consecutivo ?? 'N/A',
            $inventario->desc_sku,
            $inventario->serial ?? 'N/A',
            $inventario->descripcion_elemento,
            $inventario->atributos ?? 'N/A',
            $inventario->fecha_adq ? $inventario->fecha_adq->format('d/m/Y') : 'N/A',
            $inventario->valor_adq,
            $inventario->fecha_mant ? $inventario->fecha_mant->format('d/m/Y') : 'N/A',
            $inventario->acciones ?? 'N/A',
            ucfirst($inventario->estado),
            ucfirst(str_replace('_', ' ', $inventario->uso ?? 'N/A')),
            $inventario->contrato ?? 'N/A',
            $inventario->nombre_responsable ?? 'N/A',
            $inventario->cedula ?? 'N/A',
            ucfirst(str_replace('_', ' ', $inventario->vinculacion ?? 'N/A')),
            $inventario->created_at ? $inventario->created_at->format('d/m/Y H:i:s') : 'N/A',
            $inventario->updated_at ? $inventario->updated_at->format('d/m/Y H:i:s') : 'N/A',
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Estilo para el encabezado
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                    'size' => 12
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '667eea']
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'A' => 15,  // Imagen
            'B' => 8,   // ID
            'C' => 12,  // IR ID
            'D' => 12,  // IV ID
            'E' => 15,  // Código Regional
            'F' => 15,  // Código Centro
            'G' => 20,  // Descripción Almacén
            'H' => 15,  // No. Placa
            'I' => 15,  // Consecutivo
            'J' => 20,  // Desc. SKU
            'K' => 15,  // Serial
            'L' => 40,  // Descripción Completa
            'M' => 30,  // Atributos
            'N' => 15,  // Fecha Adquisición
            'O' => 18,  // Valor Adquisición
            'P' => 20,  // Gestión
            'Q' => 20,  // Acciones
            'R' => 12,  // Estado
            'S' => 20,  // Uso
            'T' => 18,  // Contrato/PCN
            'U' => 20,  // Responsable
            'V' => 15,  // Cédula
            'W' => 20,  // Vinculación
            'X' => 20,  // Fecha Creación
            'Y' => 20,  // Fecha Actualización
        ];
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Obtener el rango de datos
                $lastRow = $event->sheet->getDelegate()->getHighestRow();
                $lastColumn = $event->sheet->getDelegate()->getHighestColumn();
                
                // Aplicar bordes a todas las celdas con datos
                $event->sheet->getDelegate()->getStyle('A1:' . $lastColumn . $lastRow)
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);
                
                // Aplicar alineación a las columnas numéricas
                $event->sheet->getDelegate()->getStyle('A:A') // Imagen
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);
                
                $event->sheet->getDelegate()->getStyle('B:B') // ID
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);
                
                $event->sheet->getDelegate()->getStyle('O:O') // Valor Adquisición
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                
                $event->sheet->getDelegate()->getStyle('R:R') // Estado
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);
                
                // Aplicar formato de moneda a la columna de valor
                $event->sheet->getDelegate()->getStyle('O2:O' . $lastRow)
                    ->getNumberFormat()
                    ->setFormatCode('"$"#,##0');
                
                // Aplicar colores alternados a las filas
                for ($i = 2; $i <= $lastRow; $i++) {
                    if ($i % 2 == 0) {
                        $event->sheet->getDelegate()->getStyle('A' . $i . ':' . $lastColumn . $i)
                            ->getFill()
                            ->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()
                            ->setRGB('F8F9FA');
                    }
                }
                
                // Ajustar altura de filas para las imágenes
                for ($i = 2; $i <= $lastRow; $i++) {
                    $event->sheet->getDelegate()->getRowDimension($i)->setRowHeight(80);
                }
                
                // Congelar la primera fila (encabezados)
                $event->sheet->getDelegate()->freezePane('A2');
            },
        ];
    }

    /**
     * @return array
     */
    public function drawings()
    {
        // Verificar si GD está disponible
        if (!extension_loaded('gd')) {
            // Si GD no está disponible, intentar cargarlo
            if (function_exists('dl') && !dl('php_gd.dll')) {
                // Si no se puede cargar GD, retornar array vacío
                return [];
            }
        }
        
        $drawings = [];
        $inventario = $this->collection();
        
        foreach ($inventario as $index => $item) {
            if ($item->foto && file_exists(public_path('uploads/inventario/' . $item->foto))) {
                try {
                    $drawing = new Drawing();
                    $drawing->setName('Imagen ' . $item->ir_id);
                    $drawing->setDescription('Imagen del item ' . $item->ir_id);
                    $drawing->setPath(public_path('uploads/inventario/' . $item->foto));
                    $drawing->setHeight(60);
                    $drawing->setWidth(60);
                    $drawing->setCoordinates('A' . ($index + 2)); // +2 porque la fila 1 es el encabezado
                    $drawing->setOffsetX(5);
                    $drawing->setOffsetY(5);
                    
                    $drawings[] = $drawing;
                } catch (\Exception $e) {
                    // Si hay error al procesar la imagen, continuar sin ella
                    continue;
                }
            }
        }
        
        return $drawings;
    }
}