<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Tienda;
use App\Models\Zona;
use Livewire\WithPagination;

class TablaTiendas extends Component
{
    use WithPagination;

    public $tiendaId, $name, $direccion, $estatus, $zona, $zonas;
    public $showEditModal = false;

    protected $listeners = ['refreshTablaTiendas' => '$refresh'];

    public function mount()
    {
        $this->cargarSelector();
    }

    public function eliminarTienda($id)
    {
        $tienda = Tienda::findOrFail($id);
        $tienda->delete();
        session()->flash('success', 'Tiendas eliminado correctamente.');
        $this->resetPage();
    }

    public function restaurarTienda($id)
    {
        $tienda = Tienda::withTrashed()->findOrFail($id);
        $tienda->restore();
        session()->flash('success', 'Tiendas restaurado correctamente.');
        $this->resetPage();
    }

    public function editarTienda($id)
    {
        $tienda = Tienda::findOrFail($id);
        $this->tiendaId = $tienda->id;
        $this->name = $tienda->nombre;
        $this->direccion = $tienda->direccion;
        $this->zona = $tienda->zona_id;
        $this->estatus = $tienda->estatus;
        $this->showEditModal = true; // Mostrar el modal de edición
    }

    public function actualizarTienda()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
        ]);

        $tienda = Tienda::findOrFail($this->userId);
        $tienda->nombre = $this->name;
        $tienda->direccion = $this->direccion;
        $tienda->zona_id = $this->zona;
        $tienda->estatus = $this->estatus;
        $tienda->save();

        session()->flash('success', 'Tienda actualizada correctamente.');
        $this->reset(['showEditModal', 'tiendaId', 'name', 'direccion', 'zona', 'estatus']); // Resetear datos
    }

    public function cargarSelector(){
        $this->zonas = Zona::all();
    }

    public function render()
    {
        return view('livewire.admin.tabla-tiendas', [
            'tiendas' => Tienda::withTrashed()->paginate(10) // Carga usuarios con SoftDeletes
        ]);
    }
}
