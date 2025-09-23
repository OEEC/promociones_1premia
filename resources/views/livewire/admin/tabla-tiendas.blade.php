<div>
    @if (session()->has('success'))
        <div class="crud-alert crud-alert-success">{{ session('success') }}</div>
    @endif

<div class="crud-promo-table">
    <div class="table-responsive">
        <table class="promo-table">
            <thead>
                <tr>
                    <th class="promo-th">#</th>
                    <th class="promo-th">Nombre</th>
                    <th class="promo-th">Direccion</th>
                    <th class="promo-th">Zona</th>
                    <th class="promo-th">Estatus</th>
                    <th class="promo-th">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tiendas as $tienda)
                    <tr class="promo-tr {{ $tienda->trashed() ? 'table-danger' : '' }}">
                        <td class="promo-td">{{ $loop->index + 1}}</td>
                        <td class="promo-td">{{ $tienda->nombre }}</td>
                        <td class="promo-td">{{ $tienda->direccion }}</td>
                        <td class="promo-td">{{ $tienda->zona->nombre ?? '' }}</td>
                        <td class="promo-td">{{ $tienda->trashed() ? 'Eliminado' : 'Activo' }}</td>
                        <td class="promo-td">
                            <div class="promo-btn-group">
                                @if ($tienda->trashed())
                                    <button wire:click="restaurarTienda({{ $tienda->id }})" class="promo-btn promo-btn-success promo-btn-sm">
                                        <i class="bi bi-recycle"></i>
                                        Restaurar
                                    </button>
                                @else
                                    <button wire:click="eliminarTienda({{ $tienda->id }})" class="promo-btn promo-btn-danger promo-btn-sm">
                                        <i class="bi bi-trash"></i>
                                        Eliminar
                                    </button>
                                    <button wire:click="editarTienda({{ $tienda->id }})" class="promo-btn promo-btn-primary promo-btn-sm">
                                        <i class="bi bi-pencil-square"></i>
                                        Editar
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
    <!-- Paginación -->
    <div>
        {{ $tiendas->links() }}
    </div>

    <!-- Modal para Editar Estacion -->
    <div class="promo-modal-container">
        @if($showEditModal)
            <div class="modal fade show d-block" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Editar Tienda</h5>
                            <button type="button" class="modal-close" wire:click="$set('showEditModal', false)">
                                &times;
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="promo-form-group">
                                <label class="promo-form-label"><i class="bi bi-shop"></i> Nombre:</label>
                                <input type="text" class="form-control" wire:model="name">
                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="promo-form-group">
                                <label class="promo-form-label"><i class="bi bi-geo-alt-fill"></i> Dirección:</label>
                                <input type="text" class="form-control" wire:model="direccion">
                                @error('direccion') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="promo-form-group">
                                <label class="promo-form-label"><i class="bi bi-pin-map"></i> Zonas:</label>
                                <select wire:model="zona" class="promo-form-select">
                                    <option value="">Selecciona una zona</option>
                                    @foreach ($zonas as $zona)
                                        <option value="{{ $zona->id }}">{{ $zona->nombre }}</option>
                                    @endforeach
                                </select>
                                @error('zona') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="promo-btn promo-btn-secondary" wire:click="$set('showEditModal', false)"><i class="bi bi-x"></i> Cerrar</button>
                            <button type="button" class="promo-btn promo-btn-success" wire:click="actualizarTienda"><i class="bi bi-save-fill"></i> Guardar cambios</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-backdrop fade show"></div>
        @endif
    </div>
</div>