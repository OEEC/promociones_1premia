<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Promocion;
use Livewire\WithPagination;

class TablaPromociones extends Component
{
    use WithPagination;

    public $promocionId, $nombre_promo, $img_promo, $fecha_vigencia_promo, $estatus_promo, $hora_inicio_promo, $hora_fin_promo, $dias_aplicables_promo;
    public $showEditModal = false;
    public $diasSemana = [
        'Lunes',
        'Martes',
        'Miércoles',
        'Jueves',
        'Viernes',
        'Sábado',
        'Domingo',
    ];

    protected $listeners = ['refreshTablaPromociones' => '$refresh'];

    public function eliminarPromocion($id)
    {
        $Promocion = Promocion::findOrFail($id);
        $Promocion->delete();
        session()->flash('success', 'Promocions eliminado correctamente.');
        $this->resetPage();
    }

    public function restaurarPromocion($id)
    {
        $Promocion = Promocion::withTrashed()->findOrFail($id);
        $Promocion->restore();
        session()->flash('success', 'Promocions restaurado correctamente.');
        $this->resetPage();
    }

    public function editarPromocion($id)
    {
        $Promocion = Promocion::findOrFail($id);
        $this->promocionId = $Promocion->id;
        $this->nombre_promo = $Promocion->nombre;
        $this->img_promo = $Promocion->imagen;
        $this->fecha_vigencia_promo = $Promocion->fecha_vigencia;
        $this->estatus_promo = $Promocion->estatus;
        $this->hora_inicio_promo = $Promocion->hora_inicio;
        $this->hora_fin_promo = $Promocion->hora_fin;
        $this->dias_aplicables_promo = json_decode($Promocion->dias_aplicables, true) ?? [];
        $this->showEditModal = true; // Mostrar el modal de edición
    }

    public function actualizarPromocion()
    {
        $this->validate([
            'nombre_promo' => 'required|string|max:255',
            'fecha_vigencia_promo' => 'required|date|after_or_equal:today',
        ]);

        $Promocion = Promocion::findOrFail($this->promocionId);
        $Promocion->nombre = $this->nombre_promo;
        $Promocion->imagen = $this->img_promo;
        $Promocion->fecha_vigencia = $this->fecha_vigencia_promo;
        $Promocion->estatus = $this->estatus_promo;
        $Promocion->hora_inicio = $this->hora_inicio_promo;
        $Promocion->hora_fin = $this->hora_fin_promo;
        $Promocion->dias_aplicables = json_encode($this->dias_aplicables_promo); // Asegúrate de tener esta columna en la base de datos
        $Promocion->save();

        session()->flash('success', 'Promocion actualizada correctamente.');
        $this->reset(['showEditModal', 'promocionId', 'nombre_promo', 'img_promo']); // Resetear datos
    }

    public function render()
    {
        return view('livewire.admin.tabla-promociones', [
            'promociones' => Promocion::withTrashed()->paginate(10) // Carga promociones con SoftDeletes
        ]);
    }
}
