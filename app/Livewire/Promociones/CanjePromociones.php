<?php

namespace App\Livewire\Promociones;

use Livewire\Component;
use App\Models\Canje;
use App\Models\Cliente;
use App\Models\Promocion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;


class CanjePromociones extends Component
{
    public $noTarjeta;
    public $nombreCliente;
    public $promocionesCanjeadas = [];
    public $promocionesActivas = [];
    public $promocionSeleccionada;
    public $clienteId;
    public $cargarTabla = false;

    public function mount()
    {
        $this->promocionesActivas();
    }

    // Busca Cliente por numero de tarjeta o nombre
    public function buscarCliente()
    {
        $cliente = null;
    
        if ($this->noTarjeta) {

            $this->noTarjetaValidations();
            // Buscar en base local
            $cliente = Cliente::where('no_tarjeta', $this->noTarjeta)->first();
    
            // Si no existe, buscar en API externa
            if (is_null($cliente)) {
                try {
                   
                    $response = Http::withoutVerifying()->post('https://1premia.com.mx/progleal/getAllClientes.php', [
                        '_token' => '8df0a539612e1c0fb99ffd737afeaf4a',
                        '_tar_numero' => $this->noTarjeta,
                    ]);
    
                    $datos = $response->json();
                    dd($datos);
                    if (!is_array($datos)) {
                        session()->flash('error', 'Error al obtener datos del cliente.');
                        return;
                    }

                    if($response->successful() && isset($datos[0]['cod_id'])){
                        session()->flash('error', 'Error cliente no encontrado.');
                        return;
                    }
                    
                    if ($response->successful() && count($datos) > 0) {
                        $info = $datos[0];
    
                        // Crear persona
                        $persona = new \App\Models\Persona();
                        $persona->nombre_completo = $info['cte_nombre_completo'];
                        $persona->telefono = $info['cte_telefono'];
                        $persona->correo = $info['cte_email'];
                        $persona->fecha_nacimiento = $info['cte_fecha_nacimiento'];
                        $persona->save();
    
                        // Crear cliente
                        $cliente = new Cliente();
                        $cliente->no_tarjeta = $info['cte_num_tarjeta'];
                        $cliente->persona_id = $persona->id;
                        $cliente->puntos = $info['cte_puntos'];
                        $cliente->save();
    
                        session()->flash('success', 'Cliente encontrado y registrado.');
                        $this->clienteId = $cliente->id;
                        $this->cargarTabla = true;
                        $this->dispatch('refreshTablaCanjes', clienteId: $this->clienteId);
                    } else {
                        session()->flash('error', 'Cliente no encontrado.');
                        return;
                    }
                } catch (\Exception $e) {
                    session()->flash('error', 'Error al conectarse al API externo: ' . $e->getMessage());
                    return;
                }
            }
        } elseif ($this->nombreCliente) {
            $cliente = Cliente::whereHas('persona', function ($query) {
                $query->where('nombre_completo', 'like', '%' . $this->nombreCliente . '%');
            })->first();
        }
    
        if (is_null($cliente)) {
            session()->flash('error', 'Cliente no encontrado.');
        } else {
            $this->clienteId = $cliente->id;
            $this->cargarTabla = true;
            $this->dispatch('refreshTablaCanjes', clienteId: $this->clienteId);
        }
    }

    // Canjea promocion
    public function canjearPromocion()
    {
        if (!$this->noTarjeta && !$this->nombreCliente) {
            session()->flash('error', 'Selecciona un cliente.');
            return;
        }

        $cliente = Cliente::find($this->clienteId);
        if (is_null($cliente)) {
            session()->flash('error', 'Cliente no encontrado.');
            return;
        }

        $empleado = Auth::user()->empleado;
        if (is_null($empleado)) {
            session()->flash('error', 'Empleado no encontrado.');
            return;
        }

        if ($this->promocionSeleccionada == null or $this->promocionSeleccionada == '') {
            session()->flash('error', 'Promocion no seleccionada.');
            return;
        } else {
            $promocion = Promocion::find($this->promocionSeleccionada);

            if($promocion->hora_inicio != null){
                $horaActual = Carbon::now()->format('H:i');
                if ($horaActual < $promocion->hora_inicio && $horaActual > $promocion->hora_fin) {
                    $h_inicio = Carbon::parse($promocion->hora_inicio)->format('H:i');
                    $h_fin = Carbon::parse($promocion->hora_fin)->format('H:i');
                    session()->flash('error', 'La promoción '.$promocion->nombre.' solo es valida en el horario de '.$h_inicio.' a '.$h_fin);
                    return;
                }   
            }
        }

        $canje = new Canje();
        $canje->promocion_id = $this->promocionSeleccionada;
        $canje->cliente_id = $cliente->id;
        $canje->empleado_id = $empleado->id;
        $canje->tienda_id = $empleado->tienda_id;
        $canje->estatus = 1;
        if ($canje->save()) {
            $this->buscarCliente(); // Actualizar datos
            session()->flash('success', 'Promoción canjeada exitosamente.');
            $this->dispatch('refreshTablaCanjes', clienteId: $this->clienteId);
        } else {
            session()->flash('error', 'Error al canjear la promoción.');
        }
    }


    // Obtiene promociones activas
    public function promocionesActivas()
    {
    $actualDate = now();
    $diaActual = Carbon::now()->locale('es')->dayName; // "lunes", "martes", etc.
    $diaActual = ucfirst($diaActual); // para que coincida con "Lunes", "Martes", etc.

    $this->promocionesActivas = Promocion::where('fecha_vigencia', '>=', $actualDate)
        ->whereJsonContains('dias_aplicables', $diaActual)
        ->get();
    }

    public function render()
    {
        return view('livewire.promociones.canje-promociones');
    }

    public function noTarjetaValidations()
    {
        // Validar que el número de tarjeta no esté vacío
        if (empty($this->noTarjeta)) {
            session()->flash('error', 'El número de tarjeta no puede estar vacío.');
            return;
        }
        // Validar que el número de tarjeta sea un número
        if (!is_numeric($this->noTarjeta)) {
            session()->flash('error', 'El número de tarjeta debe ser un número.');
            return;
        }
        // Validar que el número de tarjeta tenga la longitud correcta
        if (strlen($this->noTarjeta) < 10 || strlen($this->noTarjeta) > 16) {
            session()->flash('error', 'El número de tarjeta debe tener entre 10 y 16 dígitos.');
            return;
        }
        // Validar que el número de tarjeta no contenga caracteres especiales
        if (!preg_match('/^[0-9]+$/', $this->noTarjeta)) {
            session()->flash('error', 'El número de tarjeta no puede contener caracteres especiales.');
            return;
        }
        // Validar que el número de tarjeta no contenga espacios
        if (preg_match('/\s/', $this->noTarjeta)) {
            session()->flash('error', 'El número de tarjeta no puede contener espacios.');
            return;
        }
        // Validar que el número de tarjeta no contenga letras
        if (preg_match('/[a-zA-Z]/', $this->noTarjeta)) {
            session()->flash('error', 'El número de tarjeta no puede contener letras.');
            return;
        }
    }
}
