<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Zona;
use App\Models\Tienda;
use Livewire\WithPagination;

class Tiendas extends Component
{
    use WithPagination;

    public $name, $direccion, $estatus, $zonas, $zona;

    protected $rules = [
        'name' => 'required|string|max:255',
    ];

    public function mount()
    {
        $this->cargarSelector();
    }
    
    public function cargarSelector(){
        $this->zonas = Zona::all();
    }

    public function guardarTienda()
    {
        $this->validate();

        Tienda::create([
            'nombre' => $this->name,
            'direccion' => $this->direccion,
            'zona_id' => $this->zona,
            'estatus' => 1,
        ]);

        session()->flash('success', 'Tienda creada correctamente.');
        $this->reset(['name', 'direccion', 'zona_id','estatus']);
        $this->dispatch('refreshTablaTiendas');
    }

    public function render()
    {
        return view('livewire.admin.tiendas');
    }
}
