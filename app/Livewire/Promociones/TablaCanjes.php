<?php

namespace App\Livewire\Promociones;

use Livewire\Component;
use App\Models\Canje;
use App\Models\Cliente;
use Livewire\Attributes\On; 

class TablaCanjes extends Component
{

    public $clienteId;
    public $promocionesCanjeadas = [];
    public $cliente;

    public function mount($clienteId)
    {
        $this->clienteId = $clienteId;
        $this->cargarCliente($clienteId);
        $this->cargarPromocionesCanjeadas();
    }

    #[On('refreshTablaCanjes')]
    public function refreshTabla($clienteId)
    {
        $this->clienteId = $clienteId;
        $this->cargarCliente($clienteId);
        $this->cargarPromocionesCanjeadas();
    }

    // Busca Cliente por numero de tarjeta
    public function cargarPromocionesCanjeadas()
    {
        // Busca las promociones canjeadas por el cliente
        $this->promocionesCanjeadas = Canje::with(['promocion','empleado','tienda'])
            ->where('cliente_id', $this->clienteId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    // Busca Cliente por numero de tarjeta
    public function cargarCliente($clienteId)
    {
        $this->cliente = Cliente::find($clienteId);
    
    }
    
    
    public function render()
    {
        return view('livewire.promociones.tabla-canjes');
    }
}
