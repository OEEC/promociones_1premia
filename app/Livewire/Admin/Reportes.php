<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Tienda;
use App\Models\Promocion;
use App\Models\Canje;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CanjesExport;
use App\Exports\PromocionesPorTiendaExport;
use App\Exports\PromocionesMasCanjeadasExport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Reportes extends Component
{
    public $fecha_inicio;
    public $fecha_fin;
    public $no_tarjeta;
    public $nombre_cliente;
    public $promocion;
    public $empleado;
    public $tienda;
    public $promociones = [];
    public $tiendas = [];
    public $tienda_usuario;

    public function mount()
    {
        $this->fecha_inicio = now()->subDays(30)->format('Y-m-d');
        $this->fecha_fin = now()->format('Y-m-d');
        $this->cargarSelectores();
    }

    public function filtrar()
    {
        // Emitir evento para actualizar el componente TablaHistorialTienda
        $this->dispatch('filtrarTabla', [
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
            'no_tarjeta' => $this->no_tarjeta,
            'nombre_cliente' => $this->nombre_cliente,
            'promocion' => $this->promocion,
            'empleado' => $this->empleado,
            'tienda' => $this->tienda,
        ]);
    }

    public function cargarSelectores(){
        $this->tiendas = Tienda::all();
        $this->promociones = Promocion::all();
    }

    //historial de promociones que se envia para descarga en excel
    public function cargarPromocionesCanjeadas()
    {
        $query = Canje::query();
        
        if ($this->fecha_inicio && $this->fecha_fin) {
            $inicio = $this->fecha_inicio . " 00:00:00";
            $fin = $this->fecha_fin . " 23:59:59";
            $query->whereBetween('created_at', [$inicio, $fin]);
        } elseif ($this->fecha_inicio) {
            $query->whereDate('created_at', '>=', $this->fecha_inicio);
        } elseif ($this->fecha_fin) {
            $query->whereDate('created_at', '<=', $this->fecha_fin);
        }

                if ($this->no_tarjeta) {
            $query->whereHas('cliente', function ($q) {
                $q->where('no_tarjeta', 'like', '%' . $this->no_tarjeta . '%');
            });
        }

        if ($this->nombre_cliente) {
            $query->whereHas('cliente.persona', function ($q) {
                $q->where('nombre_completo', 'like', '%' . $this->nombre_cliente . '%');
            });
        }

        if ($this->promocion != 0) {
            $query->where('promocion_id', $this->promocion);
        }

        if ($this->empleado) {
            $query->whereHas('empleado.persona', function ($q) {
                $q->where('nombre_completo', 'like', '%' . $this->empleado . '%');
            });
        }

        if ($this->tienda != 0) {
            $query->where('tienda_id', $this->tienda);
        }
        return $query->with(['promocion', 'empleado.persona', 'tienda', 'cliente.persona']);
    }

    public function limpiarFiltros()
    {
        $this->reset(['fecha_inicio', 'fecha_fin', 'no_tarjeta', 'nombre_cliente', 'promocion', 'empleado', 'tienda']);
        $this->filtrar();
    }
    //Reporte general de promociones canjeadas
    public function exportarExcel()
    {
        $query = $this->cargarPromocionesCanjeadas();

        return Excel::download(new CanjesExport($query), 'Reporte_general_' . now()->format('Ymd_His') . '.xlsx');
    }

    //Reporte para saber que tineda tiene mas canjes
    public function exportarResumenTiendas()
    {
        return Excel::download(
            new PromocionesPorTiendaExport($this->fecha_inicio, $this->fecha_fin),
            'Reporte_total_tiendas_' . now()->format('Ymd_His') . '.xlsx'
        );
    }

    public function exportarPromocionesMasCanjeadas()
    {
        return Excel::download(
            new PromocionesMasCanjeadasExport($this->fecha_inicio, $this->fecha_fin),
            'Promociones_mas_canjeadas' . now()->format('Ymd_His') . '.xlsx'
        );
    }

    public function render()
    {
        return view('livewire.admin.reportes');
    }
}
