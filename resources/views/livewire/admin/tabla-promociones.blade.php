<div>
    @if (session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>imagen</th>
                <th>fecha vigencia</th>
                <th>Estatus</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($promociones as $promocion)
                <tr class="{{ $promocion->trashed() ? 'table-danger' : '' }}">
                    <td>{{ $loop->index + 1}}</td>
                    <td>{{ $promocion->nombre }}</td>
                    <td>{{ $promocion->imagen ?? '' }}</td>
                    <td>{{ $promocion->fecha_vigencia }}</td>
                    <td>{{ $promocion->trashed() ? 'Eliminado' : 'Activo' }}</td>
                    <td>
                        @if ($promocion->trashed())
                            <button wire:click="restaurarPromocion({{ $promocion->id }})" class="btn btn-success btn-sm">
                                Restaurar
                            </button>
                        @else
                            <button wire:click="eliminarPromocion({{ $promocion->id }})" class="btn btn-danger btn-sm">
                                Eliminar
                            </button>
                            <button wire:click="editarPromocion({{ $promocion->id }})" class="btn btn-primary btn-sm">
                                Editar
                            </button>
                        @endif
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Paginación -->
    <div>
        {{ $promociones->links() }}
    </div>

    <!-- Modal para Editar Usuario -->
    @if($showEditModal)
        <div class="modal fade show d-block" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Promocion</h5>
                        <button type="button" class="close" wire:click="$set('showEditModal', false)">
                            &times;
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nombre:</label>
                            <input type="text" class="form-control" wire:model="nombre_promo">
                            @error('nombre_promo') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="imagen" class="form-label">Imagen</label>
                            <input class="form-control" type="file" id="imagen" wire:model="imagen" placeholder="Selecciona una imagen">
                            @error('imagen') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="fecha_vigencia">Fecha vigencia</label>
                            <input type="date" id="fecha_vigencia" wire:model.defer="fecha_vigencia" class="form-control">
                            @error('fecha_vigencia') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Estatus:</label>
                            <select class="form-control" wire:model="estatus">
                                <option value="2">Selecciona esttaus</option>
                                <option value="0">Activa</option>
                                <option value="1">Inhabilitada</option>
                            </select>
                            @error('estatus') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="$set('showEditModal', false)">Cerrar</button>
                        <button type="button" class="btn btn-success" wire:click="actualizarUsuario">Guardar cambios</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif
</div>