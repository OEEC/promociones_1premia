<div class="mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form wire:submit.prevent="login">
                <h3 class="text-center">Iniciar sesión</h3>
                
                <div class="form-group mb-3">
                    <label for="name"><i class="bi bi-person-circle"></i> Nombre:</label>
                    <input type="text" id="name" class="form-control" wire:model="name">
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                
                <div class="form-group mb-3">
                    <label for="password"><i class="bi bi-asterisk"></i>  Contraseña:</label>
                    <input type="password" id="password" class="form-control" wire:model="password">
                    @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                
                {{-- <div class="form-check mb-3">
                    <input type="checkbox" id="remember" class="form-check-input" wire:model="remember">
                    <label class="form-check-label" for="remember">Recuérdame</label>
                </div> --}}
                
                <button type="submit" class="btn btn-primary w-100">Iniciar sesión</button>
            </form>
        </div>
    </div>
</div>