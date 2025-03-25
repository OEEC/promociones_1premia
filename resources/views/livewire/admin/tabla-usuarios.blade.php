<div>
    @if (session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Nombre Completo</th>
                <th>Estatus</th>
                <th>Role</th>
                <th>Tiendas</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $usuario)
                <tr class="{{ $usuario->trashed() ? 'table-danger' : '' }}">
                    <td>{{ $loop->index + 1}}</td>
                    <td>{{ $usuario->name }}</td>
                    <td>{{ $usuario->email }}</td>
                    <td>{{ $usuario->empleado->persona->nombre_completo ?? '' }}</td>
                    <td>{{ $usuario->trashed() ? 'Eliminado' : 'Activo' }}</td>
                    <td>{{ $usuario->role ? 'Administrativo' : 'Tienda' }}</td>
                    <td>{{ $usuario->empleado->tienda->nombre ?? '' }}</td>
                    <td>
                        @if ($usuario->trashed())
                            <button wire:click="restaurarUsuario({{ $usuario->id }})" class="btn btn-success btn-sm">
                                <i class="bi bi-plus"></i>
                                Restaurar
                            </button>
                        @else
                            <button wire:click="eliminarUsuario({{ $usuario->id }})" class="btn btn-danger btn-sm">
                                <i class="bi bi-dash"></i>
                                Eliminar
                            </button>
                            <button wire:click="editarUsuario({{ $usuario->id }})" class="btn btn-primary btn-sm">
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
        {{ $usuarios->links() }}
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
                            <i class="bi bi-person-fill"></i>
                            <label>Nombre de Usuario:</label>
                            <input type="text" wire:model="nombre" class="form-control">
                            @error('nombre') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <i class="bi bi-asterisk"></i>
                            <label>Nueva Contraseña (Opcional):</label>
                            <input type="password" wire:model="new_password" class="form-control">
                            @error('new_password') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <i class="bi bi-envelope-at-fill"></i>
                            <label>Email:</label>
                            <input type="email" wire:model="correo" class="form-control">
                            @error('correo') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <i class="bi bi-person-standing"></i>
                            <label>Nombre Completo empleado:</label>
                            <input type="text" wire:model="nombreCompleto" class="form-control">
                            @error('text') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <i class="bi bi-person-badge"></i>
                            <label>Rol:</label>
                            <select class="form-control" wire:model="role">
                                <option value="">Selecciona un rol</option>
                                <option value="0">Administrador</option>
                                <option value="1" wire:click="$refresh">Tienda</option>
                            </select>
                            @error('role') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                                <i class="bi bi-shop"></i>
                                <label>Tiendas:</label>
                                <select wire:model="tienda_id" class="form-control mb-2">
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
                        <button type="button" class="btn btn-secondary" wire:click="$set('showEditModal', false)"><i class="bi bi-x"></i> Cerrar</button>
                        <button type="button" class="btn btn-success" wire:click="actualizarUsuario"><i class="bi bi-save-fill"></i> Guardar cambios</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif
</div>