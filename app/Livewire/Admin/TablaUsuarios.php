<?php

namespace App\Livewire\Admin;

use App\Models\Empleado;
use Livewire\Component;
use App\Models\User;
use App\Models\Persona;
use App\Models\Tienda;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;

class TablaUsuarios extends Component
{
    use WithPagination;

    public $userId, $nombre, $correo, $nombreCompleto, $new_password, $tiendas, $tienda_id, $role = '';
    public $showEditModal = false;

    protected $listeners = ['refreshTablaUsuarios' => '$refresh'];

    public function mount()
    {
        $this->cargarSelector();
    }

    public function eliminarUsuario($id)
    {
        $usuario = User::findOrFail($id);
        $usuario->delete();
        session()->flash('success', 'Usuario eliminado correctamente.');
        $this->resetPage();
    }

    public function restaurarUsuario($id)
    {
        $usuario = User::withTrashed()->findOrFail($id);
        $usuario->restore();
        session()->flash('success', 'Usuario restaurado correctamente.');
        $this->resetPage();
    }

    public function editarUsuario($id)
    {
        $usuario = User::findOrFail($id);
        $this->userId = $usuario->id;
        $this->new_password = ''; // Limpiar el campo de contraseña
        $this->nombre = $usuario->name;
        $this->correo = $usuario->email;
        $this->nombreCompleto = $usuario->empleado->persona->nombre_completo ?? '';
        $this->tienda_id = $usuario->empleado->tienda_id;
        $this->role = $usuario->role;
        $this->showEditModal = true; // Mostrar el modal de edición
    }

    public function actualizarUsuario()
    {
        $this->validate([
            'nombre' => 'required|string|max:255',
            'nombreCompleto' => 'required|string|max:255',
            'password' => 'nullable|min:8'
        ]);

        $usuario = User::findOrFail($this->userId);
        $usuario->name = $this->nombre;
        $usuario->email = $this->correo;
        if ($this->new_password) {
            $usuario->password = Hash::make($this->new_password);
        }
        $usuario->role = $this->role;
        $usuario->save();

        $persona = Persona::findOrFail($usuario->empleado->persona->id);
        $persona->nombre_completo = $this->nombreCompleto ?? '';
        $persona->save();

        $empleado = Empleado::findOrFail($usuario->empleado->id);
        $empleado->tienda_id = $this->tienda_id;
        $empleado->save();

        session()->flash('success', 'Usuario actualizado correctamente.');
        $this->reset(['showEditModal', 'userId', 'nombre', 'correo', 'nombreCompleto']); // Resetear datos
    }

    public function cargarSelector(){
        $this->tiendas = Tienda::all();
    }

    public function render()
    {
        return view('livewire.admin.tabla-usuarios', [
            'usuarios' => User::withTrashed()->paginate(10) // Carga usuarios con SoftDeletes
        ]);
    }
}
