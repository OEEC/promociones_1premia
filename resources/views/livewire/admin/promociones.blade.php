<div class="crud-container">
    <div class="container">
        <h2 class="crud-title">Gestión de Promociones</h2>

        @if (session()->has('success'))
            <div class="crud-alert crud-alert-success">{{ session('success') }}</div>
        @endif

        <form wire:submit.prevent="guardarPromocion" enctype="multipart/form-data" class="crud-form">
            <div class="row">
                <div class="col-md-4">
                    <div class="crud-form-group">
                        <label for="nombre" class="crud-form-label">
                            <i class="bi bi-pencil-fill"></i> Nombre:
                        </label>
                        <input type="text" class="crud-form-control" wire:model="nombre" placeholder="Nombre de la promoción">
                        @error('nombre') <span class="crud-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="crud-form-group">
                        <label for="hora_inicio" class="crud-form-label">
                            <i class="bi bi-clock"></i> Hora de inicio:
                        </label>
                        <input type="time" class="crud-form-control" id="hora_inicio" wire:model="hora_inicio">
                        @error('hora_inicio') <span class="crud-error">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="crud-form-group">
                        <label for="fecha_vigencia" class="crud-form-label">
                            <i class="bi bi-calendar4-week"></i> Fecha vigencia:
                        </label>
                        <input type="date" id="fecha_vigencia" wire:model="fecha_vigencia" class="crud-form-control" min="{{ date('Y-m-d') }}">
                        @error('fecha_vigencia') <span class="crud-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="crud-form-group">
                        <label for="hora_fin" class="crud-form-label">
                            <i class="bi bi-clock-fill"></i> Hora de fin:
                        </label>
                        <input type="time" class="crud-form-control" id="hora_fin" wire:model="hora_fin">
                        @error('hora_fin') <span class="crud-error">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="crud-form-group">
                        <label for="estatus" class="crud-form-label">
                            <i class="bi bi-gear-fill"></i> Estatus:
                        </label>
                        <select class="crud-select" wire:model="estatus">
                            <option value="1">Activa</option>
                            <option value="0">Inhabilitada</option>
                        </select>
                        @error('estatus') <span class="crud-error">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <div class="crud-form-group">
                        <label class="crud-form-label">
                            <i class="bi bi-calendar-check"></i> Días aplicables:
                        </label>
                        <div class="crud-checkbox-group">
                            @foreach ($diasSemana as $diaVisual => $diaValor)
                                <label class="crud-form-check">
                                    <input type="checkbox" wire:model="dias_aplicables" value="{{ $diaValor }}" class="crud-form-check-input">
                                    <span class="crud-checkmark"></span>
                                    <span class="crud-form-check-label">{{ $diaVisual }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('dias_aplicables') <span class="crud-error">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            <!-- Input de imagen y preview lado a lado -->
            <div class="row">
                <div class="col-md-6">
                    <div class="crud-form-group">
                        <label for="imagen" class="crud-form-label">
                            <i class="bi bi-image-fill"></i> Imagen (opcional):
                        </label>
                        <input class="crud-form-control" type="file" id="imagen" wire:model="imagen" accept="image/*">
                        @error('imagen') <span class="crud-error">{{ $message }}</span> @enderror

                        <!-- Información del archivo -->
                        @if ($imagen)
                            <small class="form-text text-muted">
                                Archivo: {{ $imagen->getClientOriginalName() }} ({{ round($imagen->getSize() / 1024, 2) }} KB)
                            </small>
                        @else
                            <small class="form-text text-white">
                                La imagen es opcional. Si no subes una, la promoción se creará sin imagen.
                            </small>
                        @endif
                    </div>
                </div>

                <div class="col-md-6">
                    @if ($imagen)
                        <div class="crud-form-group text-center">
                            <label class="crud-form-label">Vista previa:</label>
                            <div class="image-preview">
                                <img src="{{ $imagen->temporaryUrl() }}" alt="Preview" class="img-thumbnail" style="max-height: 150px;">
                            </div>
                        </div>
                    @endif
                </div>
            </div>
                        <div class="text-center mt-3">
                <button type="submit" class="crud-btn crud-btn-primary">
                    <i class="bi bi-save"></i> Registrar Promoción
                </button>
                <button type="button" class="crud-btn crud-btn-secondary" wire:click="resetForm">
                    <i class="bi bi-arrow-clockwise"></i> Limpiar
                </button>
            </div>
        </form>
        
        <hr class="crud-divider">
        
        <!-- Componente de tabla -->
        @livewire('admin.tabla-promociones')
    </div>
</div>