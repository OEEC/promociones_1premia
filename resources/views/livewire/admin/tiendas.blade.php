<div class="container">
    <h2 class="text-center">Gestión de Tiendas</h2>

    @if (session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form wire:submit.prevent="guardarTienda">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label>Nombre:</label>
                    <input type="text" class="form-control" wire:model="name">
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label>Dirección:</label>
                    <input type="text" class="form-control" wire:model="direccion">
                    @error('direccion') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
             <div class="col-md-6">
                <div class="mb-3">
                        <label>Zonas:</label>
                        <select wire:model="zona" class="form-control mb-2">
                            <option value="">Selecciona una zona</option>
                            @foreach ($zonas as $zona)
                                <option value="{{ $zona->id }}">{{ $zona->nombre }}</option>
                            @endforeach
                        </select>
                    @error('zona') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label>Estatus:</label>
                    <select class="form-control" wire:model="estatus">
                        <option value="2">Selecciona un rol</option>
                        <option value="0">Activa</option>
                        <option value="1">Inhabilitada</option>
                    </select>
                    @error('estatus') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Crear Tiendas</button>
    </form>
    <hr>
    
    @livewire('admin.tabla-tiendas')
</div>