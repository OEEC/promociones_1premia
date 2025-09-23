    <!-- Este div wrapper aísla todos los estilos del login -->
    <div class="login-wrapper">
        <div class="login-container">
            <div class="login-card">
                <div class="login-header">
                    <div class="login-logo">
                        <i class="bi bi-award-fill"></i>
                    </div>
                    <h3 class="login-title">Iniciar Sesión</h3>
                    <p class="login-subtitle">Ingresa al control de promociones</p>
                </div>
                
                <form wire:submit.prevent="login">
                    <div class="login-form-group">
                        <label for="name" class="login-form-label">
                            <i class="bi bi-person-circle"></i> Nombre de usuario:
                        </label>
                        <input type="text" id="name" class="login-form-control" wire:model="name" placeholder="Ingresa tu nombre de usuario">
                        @error('name') <span class="login-error-message">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="login-form-group">
                        <label for="password" class="login-form-label">
                            <i class="bi bi-lock-fill"></i> Contraseña:
                        </label>
                        <input type="password" id="password" class="login-form-control" wire:model="password" placeholder="Ingresa tu contraseña">
                        @error('password') <span class="login-error-message">{{ $message }}</span> @enderror
                    </div>
                    
                    <button type="submit" class="btn-login">
                        <i class="bi bi-box-arrow-in-right"></i> Iniciar sesión
                    </button>
                </form>
                
                <div class="login-footer">
                    <p>¿Necesitas ayuda? <a href="#">Contacta al soporte</a></p>
                </div>
            </div>
        </div>
    </div>
