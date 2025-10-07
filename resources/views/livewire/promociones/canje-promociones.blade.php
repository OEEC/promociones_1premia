<div class="row">
    <!-- Panel de búsqueda -->
    <div class="col-md-4">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0"><i class="bi bi-person-vcard"></i> Buscar cliente</h5>
            </div>
            <div class="card-body">
                @if (session()->has('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session()->has('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <input type="text" wire:model.defer="noTarjeta" placeholder="No. de tarjeta" class="form-control mb-2">
                <input type="text" wire:model.defer="nombreCliente" placeholder="Nombre del cliente" class="form-control mb-3">

                <button wire:click="buscarCliente" class="btn btn-primary w-100">
                    <i class="bi bi-search"></i> Buscar
                </button>

                @if ($cargarTabla)
                    <hr>
                    <h6 class="fw-bold"><i class="bi bi-percent"></i> Promociones disponibles</h6>
                    <select wire:model="promocionSeleccionada" class="form-control mb-2">
                        <option value="">Selecciona una promoción</option>
                        @foreach ($promocionesActivas as $promocion)
                            <option value="{{ $promocion->id }}">{{ $promocion->nombre }}</option>
                        @endforeach
                    </select>
                    <button wire:click="canjearPromocion" class="btn btn-success w-100">
                        <i class="bi bi-star-fill"></i> Canjear
                    </button>
                @endif
            </div>
        </div>
    </div>

    <!-- Panel de tabla -->
    <div class="col-md-8">
        @if ($clienteId)
            @livewire('promociones.tabla-canjes', ['clienteId' => $clienteId])
        @endif
    </div>
</div>
