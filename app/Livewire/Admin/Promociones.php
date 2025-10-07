<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Promocion;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class Promociones extends Component
{
    use WithPagination, WithFileUploads;

    public $nombre, $imagen, $fecha_vigencia, $estatus = 1, $hora_inicio, $hora_fin;
    public $dias_aplicables = [];
    public $diasSemana = [
        'Lunes' => 'Lunes',
        'Martes' => 'Martes',
        'Miércoles' => 'Miercoles',
        'Jueves' => 'Jueves',
        'Viernes' => 'Viernes',
        'Sábado' => 'Sabado',
        'Domingo' => 'Domingo',
    ];

    protected $rules = [
        'nombre' => 'required|string|max:255',
        'imagen' => 'nullable|image|max:2048', // Cambiado a nullable
        'fecha_vigencia' => 'required|date|after_or_equal:today',
        'dias_aplicables' => 'required|array|min:1',
        'hora_inicio' => 'nullable|date_format:H:i',
        'hora_fin' => 'nullable|date_format:H:i|after:hora_inicio',
    ];

    protected $messages = [
        'imagen.image' => 'El archivo debe ser una imagen válida.',
        'fecha_vigencia.after_or_equal' => 'La fecha de vigencia no puede ser anterior a hoy.',
        'dias_aplicables.required' => 'Selecciona al menos un día aplicable.',
        'hora_fin.after' => 'La hora fin debe ser posterior a la hora inicio.',
    ];

    public function guardarPromocion()
    {
        $this->validate();

        // Guardar imagen solo si existe
        $rutaImagen = null;
        if ($this->imagen) {
            $rutaImagen = $this->imagen->store('promociones', 'public');
        }

        Promocion::create([
            'nombre' => $this->nombre,
            'imagen' => $rutaImagen, // Puede ser null
            'fecha_vigencia' => $this->fecha_vigencia,
            'estatus' => $this->estatus,
            'dias_aplicables' => json_encode($this->dias_aplicables),
            'hora_inicio' => $this->hora_inicio,
            'hora_fin' => $this->hora_fin,
        ]);

        session()->flash('success', 'Promoción creada correctamente.');
        $this->resetForm();
        $this->dispatch('refreshTablaPromociones');
    }

    public function resetForm()
    {
        $this->reset([
            'nombre', 
            'imagen', 
            'fecha_vigencia', 
            'estatus', 
            'dias_aplicables', 
            'hora_inicio', 
            'hora_fin'
        ]);
        $this->estatus = 1; // Resetear a valor por defecto
        $this->resetErrorBag();
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.admin.promociones', [
            'diasSemana' => $this->diasSemana,
        ]);
    }
}