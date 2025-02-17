<?php

namespace App\Livewire\Admin;

use App\Models\Empleado;
use Livewire\Component;
use App\Models\User;
use App\Models\Persona;
use App\Models\Tienda;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Livewire\WithPagination;

class Usuarios extends Component
{

    use WithPagination;

    public $name, $email, $password, $usuarioId, $nombreCompleto, $tiendaid, $tiendas, $role = '';
    public $modoEdicion = false;

    protected $listeners = ['editUser'];
    
    protected $rules = [
        'name' => 'required|string|max:255',
        'password' => 'required|min:6',
    ];

    public function mount()
    {
        $this->cargarSelector();
    }

    public function guardarUsuario()
    {
        $this->validate();

        User::create([
            'name' => $this->name,
            'email' => $this->email ?? '',
            'password' => Hash::make($this->password),
            'estatus' => 1,
            'role' => $this->role ?? 1,
        ]);

        Persona::create([
            'nombre_completo' => $this->nombreCompleto ?? '',
            'fecha_nacimiento' => Carbon::now(),
            'cp' => '00000',
        ]);

        Empleado::create([
            'persona_id' => Persona::latest()->first()->id,
            'user_id' => User::latest()->first()->id,
            'tienda_id' => $this->tiendaid,
            'estatus' => 1,
        ]);

        session()->flash('success', 'Usuario creado correctamente.');
        $this->reset(['name', 'email', 'password']);
        $this->dispatch('refreshTablaUsuarios');
    }

    public function editarUsuario($id)
    {
        $usuario = User::findOrFail($id);
        $this->usuarioId = $usuario->id;
        $this->name = $usuario->name;
        $this->password = $usuario->password;
        $this->email = $usuario->email;
        $this->nombreCompleto = $usuario->empleado->persona->nombre_completo;
        $this->role = $usuario->role;
        $this->tiendaid = $usuario->empleado->tienda_id;
        $this->modoEdicion = true;
    }

    public function actualizarUsuario()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'nombre_completo' => "required|string|max:500",
        ]);

        $usuario = User::findOrFail($this->usuarioId);
        $usuario->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        $persona = Persona::findOrFail($usuario->empleado->persona->id);
        $persona->update([
            'nombre_completo' => $this->nombreCompleto
        ]);
        
       // $empleado = Empleado::findOrFail($usuario->empleado->id);

        session()->flash('success', 'Usuario actualizado correctamente.');
        $this->reset(['name', 'email', 'password', 'nombreCompleto', 'role', 'tiendaid']);
        $this->dispatch('refreshTablaUsuarios');
    }

    public function cargarSelector(){
        $this->tiendas = Tienda::all();
    }

    public function updatedRole($value)
    {
        // Si el usuario selecciona "Administrador", resetea la tienda seleccionada
        if ($value != '1') {
            $this->tiendaid = null;
        }
    }

    public function render()
    {
        return view('livewire.admin.usuarios');
    }
}
