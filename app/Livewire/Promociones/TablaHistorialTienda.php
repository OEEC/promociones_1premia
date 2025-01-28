<?php

namespace App\Livewire\Promociones;

use Livewire\Component;
use App\Models\Canje;
use App\Models\Cliente;
use Livewire\Attributes\On; 

class TablaHistorialTienda extends Component
{
    public $fecha_inicio;
    public $fecha_fin;
    public $no_tarjeta;
    public $nombre_cliente;
    public $promocion;
    public $empleado;
    public $tienda;
    public $promocionesCanjeadas = [];

    public function mount()
    {
        $this->cargarPromocionesCanjeadas();
    }

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
        $this->cargarPromocionesCanjeadas();
    }

    public function cargarPromocionesCanjeadas()
    {
        $query = Canje::query();
        if ($this->fecha_inicio && $this->fecha_fin) {
            // dd($this->fecha_inicio);
            $inicio = $this->fecha_inicio;
            $inicio = $inicio." 00:00:00";
            $fin = $this->fecha_fin;
            $fin = $fin." 23:59:59";
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
                $q->where('nombre', 'like', '%' . $this->nombre_cliente . '%')
                  ->orWhere('apellido_paterno', 'like', '%' . $this->nombre_cliente . '%')
                  ->orWhere('apellido_materno', 'like', '%' . $this->nombre_cliente . '%');
            });
        }

        if ($this->promocion != 0) {
            $query->where('promocion_id', $this->promocion);
        }

        if ($this->empleado) {
            $query->whereHas('empleado.persona', function ($q) {
                $q->where('nombre', 'like', '%' . $this->empleado . '%')
                  ->orWhere('apellido_paterno', 'like', '%' . $this->empleado . '%')
                  ->orWhere('apellido_materno', 'like', '%' . $this->empleado . '%');
            });
        }

        if ($this->tienda != 0) {
            $query->where('tienda_id', $this->tienda);
        }

        $this->promocionesCanjeadas = $query->with(['promocion', 'empleado.persona', 'tienda', 'cliente.persona'])->orderBy('created_at', 'desc')->get();
    }

    public function limpiarFiltros()
    {
        $this->reset(['created_at', 'no_tarjeta', 'nombre_cliente', 'promocion', 'empleado', 'tienda']);
        $this->cargarPromocionesCanjeadas();
    }
    
    public function render()
    {
        return view('livewire.promociones.tabla-historial-tienda');
    }
}
