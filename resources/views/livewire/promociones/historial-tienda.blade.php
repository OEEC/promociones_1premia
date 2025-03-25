<div>
    <div class="text-center">
    <h3 class="color-encabezado"><b><i class="bi bi-clock-history"></i> HISTORIAL {{$tienda_usuario->nombre}}</b></h3>
        <form wire:submit.prevent="filtrar" class="mb-4">
            <div class="row">
                <div class="form-group col-md-3">
                    <label for="fecha_inicio"><i class="bi bi-calendar-plus"></i> Fecha de Canje (Inicio):</label>
                    <input type="date" id="fecha_inicio" wire:model.defer="fecha_inicio" class="form-control">
                </div>
                <div class="form-group col-md-3">
                    <label for="fecha_fin"><i class="bi bi-calendar2-minus"></i> Fecha de Canje (Fin):</label>
                    <input type="date" id="fecha_fin" wire:model.defer="fecha_fin" class="form-control">
                </div>
                <div class="form-group col-md-3">
                    <label for="no_tarjeta"><i class="bi bi-credit-card-2-front"></i> No Tarjeta:</label>
                    <input type="text" id="no_tarjeta" wire:model.defer="no_tarjeta" class="form-control" placeholder="No Tarjeta">
                </div>
                <div class="form-group col-md-3">
                    <label for="nombre_cliente"><i class="bi bi-person-bounding-box"></i> Nombre Cliente:</label>
                    <input type="text" id="nombre_cliente" wire:model.defer="nombre_cliente" class="form-control" placeholder="Nombre Cliente">
                </div>
            </div>
            <div class="row mb-3 pt-2">
                <div class="form-group col-md-3">
                    <label for="promocion"><i class="bi bi-stars"></i> Promoción:</label>
                    <select class="form-select" id="promocion" wire:model.defer="promocion" aria-label="Promociones">
                    <option selected value="0">Promociones</option>
                    @foreach ( $promociones as $promocion )
                        <option value="{{$promocion->id}}">{{$promocion->nombre}}</option>
                    @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="empleado"><i class="bi bi-person-badge-fill"></i> Empleado:</label>
                    <input type="text" id="empleado" wire:model.defer="empleado" class="form-control" placeholder="Empleado">
                </div>
                {{-- <div class="form-group col-md-3">
                    <label for="tienda">Tienda:</label>
                    <select class="form-select" id="tienda" wire:model.defer="tienda" aria-label="Tienda">
                    <option selected value="0">Tiendas</option>
                    @foreach ( $tiendas as $tienda )
                        <option value="{{$tienda->id}}">{{$tienda->nombre}}</option>
                    @endforeach
                    </select>
                </div> --}}
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> Filtrar</button>
            <button type="button" wire:click="limpiarFiltros" class="btn btn-secondary"><i class="bi bi-x-octagon"></i> Limpiar</button>
        </form>
    </div>
    @livewire('promociones.tabla-historial-tienda')
</div>