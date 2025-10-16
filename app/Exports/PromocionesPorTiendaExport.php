<?php

namespace App\Exports;

use App\Models\Tienda;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PromocionesPorTiendaExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $fecha_inicio;
    protected $fecha_fin;

    public function __construct($fecha_inicio = null, $fecha_fin = null)
    {
        $this->fecha_inicio = $fecha_inicio;
        $this->fecha_fin = $fecha_fin;
    }

    public function collection()
    {
    $inicio = $this->fecha_inicio ? $this->fecha_inicio . " 00:00:00" : null;
    $fin = $this->fecha_fin ? $this->fecha_fin . " 23:59:59" : null;

    $query = Tienda::select(
        'tiendas.id',
        'tiendas.nombre',
        DB::raw('COALESCE(COUNT(c.id), 0) as total_promociones'),
        DB::raw('MAX(c.created_at) as ultimo_canje')
    )
    ->leftJoin('canjes as c', function ($join) use ($inicio, $fin) {
        $join->on('tiendas.id', '=', 'c.tienda_id');
    
        if ($inicio && $fin) {
            $join->whereBetween('c.created_at', [$inicio, $fin]);
        } elseif ($inicio) {
            $join->where('c.created_at', '>=', $inicio);
        } elseif ($fin) {
            $join->where('c.created_at', '<=', $fin);
        }
    })
    ->groupBy('tiendas.id', 'tiendas.nombre')
    ->orderBy('total_promociones', 'desc');

    return $query->get();
    }

    public function map($row): array
    {
        return [
            $row->nombre,
            (int) $row->total_promociones ?? 0, // siempre número
            $row->ultimo_canje ? date('Y-m-d H:i:s', strtotime($row->ultimo_canje)) : '-', // muestra "-" si no hay canje
        ];
    }

    public function headings(): array
    {
        return [
            'Tienda',
            'Total de Canjeos',
            'Fecha último Canje',
        ];
    }
}
