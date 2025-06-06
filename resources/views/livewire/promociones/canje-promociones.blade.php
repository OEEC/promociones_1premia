<div>
    <div class="row">
        <div class="col-md-4">
            <h3 class="color-encabezado"><b><i class="bi bi-person-vcard"></i> Buscar cliente</b></h3>
            @if (session()->has('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session()->has('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div>
                <input type="text" wire:model.defer="noTarjeta" placeholder="No de tarjeta cliente" class="form-control mb-2">
                <input type="text" wire:model.defer="nombreCliente" placeholder="Nombre del cliente" class="form-control mb-2">
                <button wire:click="buscarCliente" class="btn btn-primary"><i class="bi bi-search"></i> Buscar</button>
            </div>
            <hr class="border border-danger border-2 opacity-50">
            @if ($cargarTabla)
                <h3 class="color-encabezado"><b><i class="bi bi-percent"></i> Promociones</b></h3>
                <select wire:model="promocionSeleccionada" class="form-control mb-2">
                    <option value="">Selecciona una promoción</option>
                    @foreach ($promocionesActivas as $promocion)
                        <option value="{{ $promocion->id }}">{{ $promocion->nombre }}</option>
                    @endforeach
                </select>
                <button wire:click="canjearPromocion" class="btn btn-success"><i class="bi bi-star-fill"></i> Canjear</button>
                <hr class="border border-danger border-2 opacity-50">
            @endif
        </div>
        <div class="col-md-8">
            @if ($clienteId)
                @livewire('promociones.tabla-canjes', ['clienteId' => $clienteId])
            @endif
        </div>
    </div>
</div>