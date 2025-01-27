<?php

namespace App\Livewire\Promociones;

use Livewire\Component;
use App\Models\Tienda;
use App\Models\Promocion;
use Illuminate\Support\Facades\Auth;

class HistorialTienda extends Component
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
        $this->tiendaNombre();
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

    public function tiendaNombre()
    {
        $this->tienda_usuario = Tienda::find(Auth::user()->empleado->tienda_id);
    }

    public function limpiarFiltros()
    {
        $this->reset(['fecha_inicio', 'fecha_fin', 'no_tarjeta', 'nombre_cliente', 'promocion', 'empleado', 'tienda']);
        $this->filtrar();
    }
    
    public function render()
    {
        return view('livewire.promociones.historial-tienda');
    }
}
