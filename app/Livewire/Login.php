<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public $name = ''; // Cambiar de username a name
    public $password = '';
    public $remember = false;

    public function login()
    {
        $credentials = $this->validate([
            'name' => 'required', // Validar el campo name
            'password' => 'required',
        ]);

        // Cambiar el campo de email a name en Auth::attempt
        if (Auth::attempt(['name' => $this->name, 'password' => $this->password], $this->remember)) {
            session()->regenerate();
            if (Auth::user()->role == 0) { // Administrador
                return redirect()->intended('administrador');
            } elseif (Auth::user()->role == 1) { // Empleado
                return redirect()->intended('tienda');
            }
        }

        $this->addError('name', 'Las credenciales no son correctas.');
    }

    public function render()
    {
        return view('livewire.login');
    }
}