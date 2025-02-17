<div class="container">
    <h2 class="text-center">Gestión de Promociones</h2>

    @if (session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form wire:submit.prevent="guardarPromocion">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="nombre"  class="form-label">Nombre:</label>
                    <input type="text" class="form-control" wire:model="nombre" placeholder="Nombre de la promoción">
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label for="imagen" class="form-label">Imagen:</label>
                    <input class="form-control" type="file" id="imagen" wire:model="imagen">
                    @error('imagen') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="fecha_vigencia"  class="form-label">Fecha vigencia:</label>
                    <input type="date" id="fecha_vigencia" wire:model.defer="fecha_vigencia" class="form-control">
                    @error('fecha_vigencia') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label for="estatus"  class="form-label">Estatus:</label>
                    <select class="form-control" wire:model="estatus">
                        <option value="2">Selecciona un estatus</option>
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
    
    @livewire('admin.tabla-promociones')
</div>