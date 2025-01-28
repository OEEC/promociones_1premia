<?php

namespace App\Livewire\Promociones;

use Livewire\Component;
use App\Models\Promocion;
use Livewire\Attributes\On; 

class TablaPromocionesTienda extends Component
{
    public $fecha_inicio;
    public $fecha_fin;
    public $estatus;
    public $promocion;
    public $promociones = [];


    public function mount()
    {
        $this->listaPromociones();
    }

    #[On('filtrarTabla')]
    public function actualizarFiltros($filtros)
    {
        // Emitir evento para actualizar el componente TablaHistorialTienda
        $this->estatus = $filtros['estatus'];
        $this->promocion = $filtros['promocion'];
        $this->filtrarPromociones();
    }

    public function filtrarPromociones()
    {
        $query = Promocion::query();

        if ($this->promocion) {
            $query->where('nombre', 'like', '%' . $this->promocion . '%');
        }
        //ESta como diferente a 2 porque los estatus son 0 inactivo y 1 activo
        if ($this->estatus != 2) {
            $query->where('estatus', $this->estatus);
        }

        $this->promociones = $query->get();
    }

    public function listaPromociones()
    {
        $this->promociones = Promocion::all();
    }

    public function limpiarFiltros()
    {
        $this->reset(['created_at', 'no_tarjeta', 'promocion',]);
        $this->cargarPromocionesCanjeadas();
    }
    

    public function render()
    {
        return view('livewire.promociones.tabla-promociones-tienda');
    }
}
