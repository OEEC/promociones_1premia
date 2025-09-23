 <div class="crud-container">
    <div class="container">
        <h2 class="crud-title">Gestión de Usuarios</h2>

        @if (session()->has('success'))
            <div class="crud-alert crud-alert-success">{{ session('success') }}</div>
        @endif

        <form wire:submit.prevent="guardarUsuario" class="crud-form">
            <div class="row">
                <div class="col-md-4">
                    <div class="crud-form-group">
                        <label class="crud-form-label"><i class="bi bi-person-fill"></i> Nombre de Usuario:</label>
                        <input type="text" class="crud-form-control" wire:model="name">
                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="crud-form-group">
                        <label class="crud-form-label"><i class="bi bi-envelope-at-fill"></i> Email:</label>
                        <input type="email" class="crud-form-control" wire:model="email">
                        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="crud-form-group">
                        <label class="crud-form-label"><i class="bi bi-person-standing"></i> Nombre completo empleado:</label>
                        <input type="texto" class="crud-form-control" wire:model="nombreCompleto">
                        @error('nombreCompleto') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="crud-form-group">
                        <label class="crud-form-label"><i class="bi bi-person-badge"></i> Rol:</label>
                        <select class="crud-select" wire:model="role">
                            <option value="">Selecciona un rol</option>
                            <option value="0">Administrador</option>
                            <option value="1" wire:click="$refresh">Tienda</option>
                        </select>
                        @error('role') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                </div>
                <div class="col-md-4">      
                    <div class="crud-form-group">
                        <label class="crud-form-label"><i class="bi bi-asterisk"></i> Contraseña:</label>
                        <input type="password" class="crud-form-control" wire:model="password">
                        @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="crud-form-group">
                            <label class="crud-form-label"><i class="bi bi-shop"></i> Tiendas:</label>
                            <select wire:model="tiendaid" class="crud-select">
                                <option value="">Selecciona una tienda</option>
                                <option value="0">No aplica</option>
                                @foreach ($tiendas as $tienda)
                                    <option value="{{ $tienda->id }}">{{ $tienda->nombre }}</option>
                                @endforeach
                            </select>
                        @error('empleado') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            <div class="text-center mt-3">
                <button type="submit" class="crud-btn crud-btn-primary"><i class="bi bi-save"></i>Crear Usuario</button>
            </div>
        </form>

       <hr class="crud-divider">
        
        @livewire('admin.tabla-usuarios')
    </div>
</div>