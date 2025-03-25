<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Promocion;
use Livewire\WithPagination;

class Promociones extends Component
{

    use WithPagination;

    public $nombre, $imagen, $fecha_vigencia, $estatus;

    protected $rules = [
        'nombre' => 'required|string|max:255',
        'fecha_vigencia' => 'required|date',
    ];

    public function guardarPromocion()
    {
        $this->validate();

        Promocion::create([
            'nombre' => $this->nombre,
            'imagen' => $this->imagen ?? '',
            'fecha_vigencia' => $this->fecha_vigencia,
            'estatus' => 1,
        ]);

        session()->flash('success', 'Promoción creada correctamente.');
        $this->reset(['nombre', 'imagen', 'fecha_vigencia']);
        $this->dispatch('refreshTablaPromociones');
    }

    public function render()
    {
        return view('livewire.admin.promociones');
    }
}
