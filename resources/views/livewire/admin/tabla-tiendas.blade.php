<div>
    @if (session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Direccion</th>
                <th>Zona</th>
                <th>Estatus</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tiendas as $tienda)
                <tr class="{{ $tienda->trashed() ? 'table-danger' : '' }}">
                    <td>{{ $loop->index + 1}}</td>
                    <td>{{ $tienda->nombre }}</td>
                    <td>{{ $tienda->direccion }}</td>
                    <td>{{ $tienda->zona->nombre ?? '' }}</td>
                    <td>{{ $tienda->trashed() ? 'Eliminado' : 'Activo' }}</td>
                    <td>
                        @if ($tienda->trashed())
                            <button wire:click="restaurarTienda({{ $tienda->id }})" class="btn btn-success btn-sm">
                                Restaurar
                            </button>
                        @else
                            <button wire:click="eliminarTienda({{ $tienda->id }})" class="btn btn-danger btn-sm">
                                Eliminar
                            </button>
                            <button wire:click="editarTienda({{ $tienda->id }})" class="btn btn-primary btn-sm">
                                Editar
                            </button>
                        @endif
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Paginación -->
    <div>
        {{ $tiendas->links() }}
    </div>

    <!-- Modal para Editar Usuario -->
    @if($showEditModal)
        <div class="modal fade show d-block" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Usuario</h5>
                        <button type="button" class="close" wire:click="$set('showEditModal', false)">
                            &times;
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nombre:</label>
                            <input type="text" class="form-control" wire:model="name">
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Dirección:</label>
                            <input type="text" class="form-control" wire:model="direccion">
                            @error('direccion') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Zonas:</label>
                            <select wire:model="zona" class="form-control mb-2">
                                <option value="">Selecciona una zona</option>
                                @foreach ($zonas as $zona)
                                    <option value="{{ $zona->id }}">{{ $zona->nombre }}</option>
                                @endforeach
                            </select>
                            @error('zona') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Estatus:</label>
                            <select class="form-control" wire:model="estatus">
                                <option value="2">Selecciona un rol</option>
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