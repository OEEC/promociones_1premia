<?php

namespace App\Exports;

use App\Models\Canje;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class CanjesExport implements FromCollection, WithHeadings, WithMapping, WithEvents, ShouldAutoSize, WithColumnFormatting
{
    protected $query;
    protected $totalCanjes = 0;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function collection()
    {
        $canjes = $this->query->get();
        $this->totalCanjes = $canjes->count();
        return $canjes;
    }

    public function map($canje): array
    {
        return [
            optional($canje->tienda)->nombre,
            optional($canje->promocion)->nombre,
            //Devolvemos el objeto Carbon directamente
            $canje->created_at,
            optional($canje->empleado->persona)->nombre_completo,
            //Convertimos la tarjeta a número si es posible
            " ".strval(optional($canje->cliente)->no_tarjeta),
            optional($canje->cliente->persona)->nombre_completo,
        ];
    }

    public function headings(): array
    {
        return [
            'Tienda',
            'Promoción',
            'Fecha de Canje',
            'Empleado',
            'No. Tarjeta',
            'Cliente',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow() + 2; // deja una fila en blanco antes del total

                // Escribe el total de canjes
                $sheet->setCellValue("A{$highestRow}", 'TOTAL DE CANJES:');
                $sheet->setCellValue("B{$highestRow}", $this->totalCanjes);

                // Estilo negrita para el total
                $sheet->getStyle("A{$highestRow}:B{$highestRow}")->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => '000000'],
                        'size' => 12,
                    ],
                ]);
            },
        ];
    }

    public function columnFormats(): array
    {
        return [
            // La columna C es "Fecha de Canje" → formato de fecha día/mes/año hora:minuto
            'C' => NumberFormat::FORMAT_DATE_DDMMYYYY . ' hh:mm:ss',
            // Columna E como texto (para evitar notación científica)
            'E' => NumberFormat::FORMAT_TEXT,
        ];
    }
}
