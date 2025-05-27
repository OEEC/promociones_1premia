<div class="container">
    <h2 class="text-center">Gestión de Promociones</h2>

    @if (session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form wire:submit.prevent="guardarPromocion">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <i class="bi bi-pencil-fill"></i>
                    <label for="nombre"  class="form-label">Nombre:</label>
                    <input type="text" class="form-control" wire:model="nombre" placeholder="Nombre de la promoción">
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <i class="bi bi-image-fill"></i>
                    <label for="imagen" class="form-label">Imagen:</label>
                    <input class="form-control" type="file" id="imagen" wire:model="imagen">
                    @error('imagen') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <i class="bi bi-calendar4-week"></i>
                    <label for="fecha_vigencia"  class="form-label">Fecha vigencia:</label>
                    <input type="date" id="fecha_vigencia" wire:model.defer="fecha_vigencia" class="form-control">
                    @error('fecha_vigencia') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <i class="bi bi-gear-fill"></i>
                    <label for="estatus"  class="form-label">Estatus:</label>
                    <select class="form-control" wire:model="estatus">
                        <option value="2">Selecciona un estatus</option>
                        <option value="0">Activa</option>
                        <option value="1">Inhabilitada</option>
                    </select>
                    @error('estatus') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="form-label"><i class="bi bi-calendar-check"></i> Días aplicables:</label>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($diasSemana as $dia)
                            <div class="form-check">
                                <input type="checkbox" id="dia-{{ $dia }}" value="{{ $dia }}" wire:model="dias_aplicables" class="form-check-input">
                                <label class="form-check-label" for="dia-{{ $dia }}">{{ $dia }}</label>
                            </div>
                        @endforeach
                    </div>
                    @error('dias_aplicables') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="hora_inicio" class="form-label"><i class="bi bi-clock"></i> Hora de inicio:</label>
                    <input type="time" class="form-control" id="hora_inicio" wire:model="hora_inicio">
                    @error('hora_inicio') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>  
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="hora_fin" class="form-label"><i class="bi bi-clock-fill"></i> Hora de fin:</label>
                    <input type="time" class="form-control" id="hora_fin" wire:model="hora_fin">
                    @error('hora_fin') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary"><i class="bi bi-save2"></i> Registrar Promocion</button>
    </form>
    <hr>
    
    @livewire('admin.tabla-promociones')
</div>