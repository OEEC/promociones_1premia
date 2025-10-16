<?php

namespace App\Exports;

use App\Models\Promocion;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PromocionesMasCanjeadasExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
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

        $query = Promocion::select(
            'promociones.id',
            'promociones.nombre',
            DB::raw('COALESCE(COUNT(c.id), 0) as total_canjeos'),
            DB::raw('COALESCE(MAX(c.created_at), NULL) as ultimo_canje')
        )
        ->leftJoin('canjes as c', function ($join) use ($inicio, $fin) {
            $join->on('promociones.id', '=', 'c.promocion_id');
            if ($inicio && $fin) {
                $join->whereBetween('c.created_at', [$inicio, $fin]);
            } elseif ($inicio) {
                $join->where('c.created_at', '>=', $inicio);
            } elseif ($fin) {
                $join->where('c.created_at', '<=', $fin);
            }
        })
        ->groupBy('promociones.id', 'promociones.nombre')
        ->orderByDesc('total_canjeos')
        ->get();

        // Aseguramos ceros explícitos para las promociones sin canjes
        $query->transform(function ($item) {
            $item->total_canjeos = $item->total_canjeos ?? 0;
            $item->ultimo_canje = $item->ultimo_canje ?: null;
            return $item;
        });

        return $query;
    }

    public function map($row): array
    {
        return [
            $row->nombre,
            (int) $row->total_canjeos,
            $row->ultimo_canje ? date('Y-m-d H:i:s', strtotime($row->ultimo_canje)) : '-',
        ];
    }

    public function headings(): array
    {
        return [
            'Promoción',
            'Total de Canjeos',
            'Último Canje',
        ];
    }
}
