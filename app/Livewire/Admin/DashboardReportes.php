<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Tienda;
use App\Models\Canje;
use App\Models\Promocion;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardReportes extends Component
{
    public $tiendasTop = [];
    public $promocionesTop = [];
    public $canjesPorSemana = [];
    public $canjesPorAnio = [];
    public $totalCanjes = 0;
    public $readyToLoad = false;

    public function mount()
    {
        $this->cargarDatos();
    }

    public function cargarDatos()
    {
        $this->cargarTiendasTop();
        $this->cargarPromocionesTop();
        $this->cargarCanjesPorSemana();
        $this->cargarCanjesPorAnio();
        $this->cargarTotalCanjes();
        $this->readyToLoad = true;
    }

    private function cargarTotalCanjes()
    {
        $this->totalCanjes = Canje::count();
    }

    private function cargarTiendasTop()
    {
        $this->tiendasTop = Tienda::select('tiendas.nombre', DB::raw('COUNT(canjes.id) as total_canjes'))
            ->leftJoin('canjes', 'tiendas.id', '=', 'canjes.tienda_id')
            ->groupBy('tiendas.id', 'tiendas.nombre')
            ->orderByDesc('total_canjes')
            ->limit(5)
            ->get()
            ->toArray();
    }

    private function cargarPromocionesTop()
    {
        $this->promocionesTop = Promocion::select('promociones.nombre', DB::raw('COUNT(canjes.id) as total_canjes'))
            ->leftJoin('canjes', 'promociones.id', '=', 'canjes.promocion_id')
            ->groupBy('promociones.id', 'promociones.nombre')
            ->orderByDesc('total_canjes')
            ->limit(5)
            ->get()
            ->toArray();
    }

    private function cargarCanjesPorSemana()
    {
        $inicioSemana = Carbon::now()->startOfWeek();
        $finSemana = Carbon::now()->endOfWeek();

        $canjesSemana = Canje::select(DB::raw('DAYNAME(created_at) as dia'), DB::raw('COUNT(*) as total'))
            ->whereBetween('created_at', [$inicioSemana, $finSemana])
            ->groupBy('dia')
            ->get();

        $diasOrden = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $this->canjesPorSemana = collect($diasOrden)->map(function ($dia) use ($canjesSemana) {
            $canjeDia = $canjesSemana->firstWhere('dia', $dia);
            return [
                'dia' => $this->traducirDia($dia),
                'total' => $canjeDia ? $canjeDia->total : 0
            ];
        })->toArray();
    }

    private function cargarCanjesPorAnio()
    {
        $anioActual = Carbon::now()->year;
        
        // Obtener datos de todos los meses, incluso los que tienen 0 canjes
        $canjesPorMes = [];
        for ($mes = 1; $mes <= 12; $mes++) {
            $total = Canje::whereYear('created_at', $anioActual)
                ->whereMonth('created_at', $mes)
                ->count();
                
            $canjesPorMes[] = [
                'mes' => $this->obtenerNombreMes($mes),
                'total' => $total
            ];
        }
        
        $this->canjesPorAnio = $canjesPorMes;
    }

    private function traducirDia($diaIngles)
    {
        $dias = [
            'Monday' => 'Lunes',
            'Tuesday' => 'Martes',
            'Wednesday' => 'Miércoles',
            'Thursday' => 'Jueves',
            'Friday' => 'Viernes',
            'Saturday' => 'Sábado',
            'Sunday' => 'Domingo'
        ];
        
        return $dias[$diaIngles] ?? $diaIngles;
    }

    private function obtenerNombreMes($numeroMes)
    {
        $meses = [
            1 => 'Ene', 2 => 'Feb', 3 => 'Mar', 4 => 'Abr',
            5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Ago',
            9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dic'
        ];
        
        return $meses[$numeroMes] ?? 'Mes ' . $numeroMes;
    }

    public function render()
    {
        return view('livewire.admin.dashboard-reportes');
    }
}
