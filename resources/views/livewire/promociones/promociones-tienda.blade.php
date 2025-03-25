<div>
    <div class="text-center">
        <h3 class="color-encabezado"><b><i class="bi bi-percent"></i> PROMOCIÓNES</b></h3>
        <form wire:submit.prevent="filtrar" class="mb-4">
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="promocion"><i class="bi bi-percent"></i> Promoción:</label>
                    <input type="text" id="promocion" wire:model.defer="promocion" class="form-control" placeholder="Nombre promocion">
                </div>
                <div class="form-group col-md-4">
                    <label for="estatus"><i class="bi bi-gear-wide"></i> Estatus:</label>
                    <select class="form-select" id="estatus" wire:model.defer="estatus" aria-label="Estatus">
                    <option selected value="2">Estatus</option>
                    <option value="1">Vigentes</option>
                    <option value="0">Expiradas</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> Filtrar</button>
            <button type="button" wire:click="limpiarFiltros" class="btn btn-secondary"><i class="bi bi-x-octagon"></i> Limpiar</button>
        </form>
    </div>
    @livewire('promociones.tabla-promociones-tienda')
</div>