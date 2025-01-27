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
        if (is_null($cliente)) {
            session()->flash('error', 'Cliente no encontrado.');
        } else {
            $this->clienteId = $cliente->id;
            $this->cargarTabla = true;
            $this->dispatch('refreshTablaCanjes', clienteId: $this->clienteId);
        }  
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
        if (is_null($cliente)) {
            session()->flash('error', 'Cliente no encontrado.');
            return;
        }
        
        $empleado = Auth::user()->empleado;
        if (is_null($empleado)) {
            session()->flash('error', 'Empleado no encontrado.');
            return;
        }

        $canje = new Canje();
        $canje->promocion_id = $this->promocionSeleccionada;
        $canje->cliente_id = $cliente->id;
        $canje->empleado_id = $empleado->id;
        $canje->tienda_id = $empleado->tienda_id;
        $canje->estatus = 1;
        if ($canje->save()) {
            $this->buscarCliente(); // Actualizar datos
            session()->flash('success', 'Promoción canjeada exitosamente.');
            $this->dispatch('refreshTablaCanjes', clienteId: $this->clienteId);
        } else {
            session()->flash('error', 'Error al canjear la promoción.');
        }
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
