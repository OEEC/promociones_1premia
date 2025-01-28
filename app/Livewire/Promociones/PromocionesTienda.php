<?php

namespace App\Livewire\Promociones;

use Livewire\Component;
use App\Models\Promocion;

class PromocionesTienda extends Component
{
    public $fecha_inicio;
    public $fecha_fin;
    public $estatus;
    public $promocion;
    public $promociones = [];

    public function mount()
    {
        $this->fecha_inicio = now()->subDays(30)->format('Y-m-d');
        $this->fecha_fin = now()->format('Y-m-d');
        $this->cargarSelector();
    }

    public function filtrar()
    {
        // Emitir evento para actualizar el componente TablaHistorialTienda
        $this->dispatch('filtrarTabla', [
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
            'promocion' => $this->promocion,
            'estatus' => $this->estatus,
        ]);
    }

    public function cargarSelector(){
        $this->promociones = Promocion::all();
    }

    public function limpiarFiltros()
    {
        $this->reset(['fecha_inicio', 'fecha_fin', 'promocion', 'estatus']);
        $this->filtrar();
    }

    public function render()
    {
        return view('livewire.promociones.promociones-tienda');
    }
}
