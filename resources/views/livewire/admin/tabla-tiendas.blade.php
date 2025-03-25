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
                                <i class="bi bi-plus"></i>
                                Restaurar
                            </button>
                        @else
                            <button wire:click="eliminarTienda({{ $tienda->id }})" class="btn btn-danger btn-sm">
                                <i class="bi bi-dash"></i>
                                Eliminar
                            </button>
                            <button wire:click="editarTienda({{ $tienda->id }})" class="btn btn-primary btn-sm">
                                <i class="bi bi-arrow-clockwise"></i>
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

    <!-- Modal para Editar Estacion -->
    @if($showEditModal)
        <div class="modal fade show d-block" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Tienda</h5>
                        <button type="button" class="close" wire:click="$set('showEditModal', false)">
                            &times;
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <i class="bi bi-shop"></i>
                            <label>Nombre:</label>
                            <input type="text" class="form-control" wire:model="name">
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <i class="bi bi-geo-alt-fill"></i>
                            <label>Dirección:</label>
                            <input type="text" class="form-control" wire:model="direccion">
                            @error('direccion') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <i class="bi bi-pin-map"></i>
                            <label>Zonas:</label>
                            <select wire:model="zona" class="form-control mb-2">
                                <option value="">Selecciona una zona</option>
                                @foreach ($zonas as $zona)
                                    <option value="{{ $zona->id }}">{{ $zona->nombre }}</option>
                                @endforeach
                            </select>
                            @error('zona') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="$set('showEditModal', false)"><i class="bi bi-x"></i> Cerrar</button>
                        <button type="button" class="btn btn-success" wire:click="actualizarTienda"><i class="bi bi-save-fill"></i> Guardar cambios</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif
</div>