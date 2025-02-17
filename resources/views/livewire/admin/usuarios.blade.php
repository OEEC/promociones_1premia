<div class="container">
    <h2 class="text-center">Gestión de Usuarios</h2>

    @if (session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form wire:submit.prevent="guardarUsuario">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label>Nombre de Usuario:</label>
                    <input type="text" class="form-control" wire:model="name">
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                
                <div class="mb-3">
                    <label>Contraseña:</label>
                    <input type="password" class="form-control" wire:model="password">
                    @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label>Email:</label>
                    <input type="email" class="form-control" wire:model="email">
                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label>Nombre completo empleado:</label>
                    <input type="texto" class="form-control" wire:model="nombreCompleto">
                    @error('nombreCompleto') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label>Rol:</label>
                    <select class="form-control" wire:model="role">
                        <option value="">Selecciona un rol</option>
                        <option value="0">Administrador</option>
                        <option value="1" wire:click="$refresh">Tienda</option>
                    </select>
                    @error('role') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                        <label>Tiendas:</label>
                        <select wire:model="tiendaid" class="form-control mb-2">
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
        <button type="submit" class="btn btn-primary">Crear Usuario</button>

    </form>

    <hr>
    
    @livewire('admin.tabla-usuarios')
</div>