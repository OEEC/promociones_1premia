<?php

namespace App\Livewire\Promociones;

use Livewire\Component;
use App\Models\Canje;
use App\Models\Cliente;
use Livewire\Attributes\On; 
use Livewire\WithPagination;
class TablaHistorialTienda extends Component
{
    use WithPagination;

    public $fecha_inicio;
    public $fecha_fin;
    public $no_tarjeta;
    public $nombre_cliente;
    public $promocion;
    public $empleado;
    public $tienda;


    #[On('filtrarTabla')]
    public function actualizarFiltros($filtros)
    {
        $this->fecha_inicio = $filtros['fecha_inicio'];
        $this->fecha_fin = $filtros['fecha_fin'];
        $this->no_tarjeta = $filtros['no_tarjeta'];
        $this->nombre_cliente = $filtros['nombre_cliente'];
        $this->promocion = $filtros['promocion'];
        $this->empleado = $filtros['empleado'];
        $this->tienda = $filtros['tienda'];
        $this->resetPage();
    }

    // 6. Crear un método para la consulta paginada
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
        return $query->with(['promocion', 'empleado.persona', 'tienda', 'cliente.persona'])
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
    }

    public function limpiarFiltros()
    {
        $this->reset(['fecha_inicio', 'fecha_fin', 'no_tarjeta', 'nombre_cliente', 'promocion', 'empleado', 'tienda']);
        $this->resetPage();
    }
    
    public function render()
    {
        // 9. Pasar los resultados paginados a la vista
        return view('livewire.promociones.tabla-historial-tienda', [
            'promocionesCanjeadas' => $this->cargarPromocionesCanjeadas(),
        ]);
    }
}