<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Promocion;
use Livewire\WithPagination;

class Promociones extends Component
{

    use WithPagination;

    public $nombre, $imagen, $fecha_vigencia, $estatus, $hora_inicio, $hora_fin;
    public $dias_aplicables = [];
    public $diasSemana = [
        'Lunes',
        'Martes',
        'Miércoles',
        'Jueves',
        'Viernes',
        'Sábado',
        'Domingo',
    ];

    protected $rules = [
        'nombre' => 'required|string|max:255',
        'fecha_vigencia' => 'required|date',
        'dias_aplicables' => 'required|array|min:1',
    ];

    public function guardarPromocion()
    {
        $this->validate();

        Promocion::create([
            'nombre' => $this->nombre,
            'imagen' => $this->imagen ?? '',
            'fecha_vigencia' => $this->fecha_vigencia,
            'estatus' => 1,
            'dias_aplicables' => json_encode($this->dias_aplicables), // Asegúrate de tener esta columna en la base de datos
            'hora_inicio' => $this->hora_inicio,
            'hora_fin' => $this->hora_fin,
        ]);

        session()->flash('success', 'Promoción creada correctamente.');
        $this->reset(['nombre', 'imagen', 'fecha_vigencia', 'dias_aplicables', 'hora_inicio', 'hora_fin']);
        $this->dispatch('refreshTablaPromociones');
    }

    public function render()
    {
        return view('livewire.admin.promociones', [
            'diasSemana' => $this->diasSemana,
        ]);
    }
}
