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
                <th class="promo-th">Email</th>
                <th class="promo-th">Nombre Completo</th>
                <th class="promo-th">Estatus</th>
                <th class="promo-th">Role</th>
                <th class="promo-th">Tiendas</th>
                <th class="promo-th">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $usuario)
                <tr class="promo-tr {{ $usuario->trashed() ? 'promo-table-deleted' : '' }}">
                    <td class="promo-td">{{ $loop->index + 1}}</td>
                    <td class="promo-td">{{ $usuario->name }}</td>
                    <td class="promo-td">{{ $usuario->email }}</td>
                    <td class="promo-td">{{ $usuario->empleado->persona->nombre_completo ?? '' }}</td>
                    <td class="promo-td">{{ $usuario->trashed() ? 'Eliminado' : 'Activo' }}</td>
                    <td class="promo-td">{{ $usuario->role == 0 ? 'Administrativo' : 'Tienda' }}</td>
                    <td class="promo-td">{{ $usuario->empleado->tienda->nombre ?? '' }}</td>
                    <td class="promo-td">
                        <div class="promo-btn-group">
                        @if ($usuario->trashed())
                            <button wire:click="restaurarUsuario({{ $usuario->id }})" class="promo-btn promo-btn-success promo-btn-sm">
                                <i class="bi bi-recycle"></i>
                                Restaurar
                            </button>
                        @else
                            <button wire:click="eliminarUsuario({{ $usuario->id }})" class="promo-btn promo-btn-danger promo-btn-sm">
                                <i class="bi bi-trash"></i>
                                Eliminar
                            </button>
                            <button wire:click="editarUsuario({{ $usuario->id }})" class="promo-btn promo-btn-primary promo-btn-sm">
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
        {{ $usuarios->links() }}
    </div>

    <!-- Modal para Editar Usuario -->
    <div class="promo-modal-container">
        @if($showEditModal)
            <div class="modal fade show d-block" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Editar Usuario</h5>
                            <button type="button" class="modal-close" wire:click="$set('showEditModal', false)">
                                &times;
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="promo-form-group">
                                <label class="promo-form-label"><i class="bi bi-person-fill"></i> Nombre de Usuario:</label>
                                <input type="text" wire:model="nombre" class="form-control">
                                @error('nombre') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="promo-form-group">
                                <label class="promo-form-label"> <i class="bi bi-asterisk"></i> Nueva Contraseña (Opcional):</label>
                                <input type="password" wire:model="new_password" class="form-control">
                                @error('new_password') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="promo-form-group">
                                <label class="promo-form-label"><i class="bi bi-envelope-at-fill"></i> Email:</label>
                                <input type="email" wire:model="correo" class="form-control">
                                @error('correo') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="promo-form-group">
                                <label class="promo-form-label"><i class="bi bi-person-standing"></i> Nombre Completo empleado:</label>
                                <input type="text" wire:model="nombreCompleto" class="form-control">
                                @error('nombreCompleto') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="promo-form-group">
                                <label class="promo-form-label"><i class="bi bi-person-badge"></i> Rol:</label>
                                <select class="form-control" wire:model="role">
                                    <option value="">Selecciona un rol</option>
                                    <option value="0">Administrador</option>
                                    <option value="1" wire:click="$refresh">Tienda</option>
                                </select>
                                @error('role') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="promo-form-group">
                                    <label class="promo-form-label"><i class="bi bi-shop"></i> Tiendas:</label>
                                    <select wire:model="tienda_id" class="promo-form-select">
                                        <option value="">Selecciona una tienda</option>
                                        <option value="0">No aplica</option>
                                        @foreach ($tiendas as $tienda)
                                            <option value="{{ $tienda->id }}">{{ $tienda->nombre }}</option>
                                        @endforeach
                                    </select>
                                @error('tienda_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="promo-btn promo-btn-secondary" wire:click="$set('showEditModal', false)"><i class="bi bi-x"></i> Cerrar</button>
                            <button type="button" class="promo-btn promo-btn-success" wire:click="actualizarUsuario"><i class="bi bi-save-fill"></i> Guardar cambios</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-backdrop fade show"></div>
        @endif
    </div>
</div>