<?php

namespace App\Livewire\Promociones;

use Livewire\Component;
use App\Models\Canje;
use App\Models\Cliente;
use App\Models\Promocion;
use Illuminate\Support\Facades\Auth;

class CanjePromociones extends Component
{
    public $noTarjeta;
    public $promocionesCanjeadas = [];
    public $promocionesActivas = [];
    public $promocionSeleccionada;
    public $clienteId;
    public $cargarTabla = false;

    public function mount()
    {
        $this->promocionesActivas();
    }

    // Busca Cliente por numero de tarjeta
    public function buscarCliente()
    {
        
        // Busca el cliente por el numero de tarjeta
        $cliente = Cliente::where('no_tarjeta', $this->noTarjeta)->first();
        if (!$cliente) {
            session()->flash('error', 'Cliente no encontrado.');
        }  

        $this->clienteId = $cliente->id;
        $this->cargarTabla = true;
    }

    // Canjea promocion
    public function canjearPromocion()
    {
        if (!$this->noTarjeta || !$this->promocionSeleccionada) {
            session()->flash('error', 'Selecciona un cliente y una promoción.');
            return;
        }

        // Busca el cliente por el numero de tarjeta
        $cliente = Cliente::where('no_tarjeta', $this->noTarjeta)->first();
        if (!$cliente) {
            session()->flash('error', 'Cliente no encontrado.');
            return;
        }
        
        $empleado = Auth::user()->empleado;

        Canje::create([
            'cliente_id' => $cliente->id,
            'promocion_id' => $this->promocionSeleccionada,
            'empleado_id' => $empleado->id,
            'tienda_id' => $empleado->tienda_id,
             'estatus' => 1,
            'fecha_canje' => now(),
        ]);

        $this->buscarCliente($this->noTarjeta); // Actualizar datos
        session()->flash('success', 'Promoción canjeada exitosamente.');
    }

    // Obtiene promociones activas
    public function promocionesActivas()
    {
        $this->promocionesActivas = Promocion::where('fecha_vigencia', '>=', now())->get();
    }
    public function render()
    {
        return view('livewire.promociones.canje-promociones');
    }
}
