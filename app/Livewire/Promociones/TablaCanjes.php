<?php

namespace App\Livewire\Promociones;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Canje;
use App\Models\Cliente;
use Livewire\Attributes\On; 

class TablaCanjes extends Component
{
    use WithPagination;

    public $clienteId;
    public $cliente;

    public function mount($clienteId)
    {
        $this->clienteId = $clienteId;
        $this->cargarCliente($clienteId);
    }

    #[On('refreshTablaCanjes')]
    public function refreshTabla($clienteId)
    {
        $this->clienteId = $clienteId;
        $this->cargarCliente($clienteId);
        $this->resetPage();
    }

    public function cargarPromocionesCanjeadas()
    {
        return Canje::with(['promocion','empleado','tienda'])
            ->where('cliente_id', $this->clienteId)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    public function cargarCliente($clienteId)
    {
        $this->cliente = Cliente::find($clienteId);
    }
    
    public function render()
    {
        return view('livewire.promociones.tabla-canjes', [
            'promocionesCanjeadas' => $this->cargarPromocionesCanjeadas(),
        ]);
    }
}