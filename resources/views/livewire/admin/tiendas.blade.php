 <div class="crud-container">
    <div class="container">
        <h2 class="crud-title">Gestión de Tiendas</h2>

        @if (session()->has('success'))
            <div class="crud-alert crud-alert-success">{{ session('success') }}</div>
        @endif

        <form wire:submit.prevent="guardarTienda" class="crud-form">
            <div class="row">
                <div class="col-md-4">
                    <div class="crud-form-group">
                        <label class="crud-form-label"><i class="bi bi-shop"></i> Nombre:</label>
                        <input type="text" class="crud-form-control" wire:model="name">
                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="crud-form-group">
                            <label class="crud-form-label"><i class="bi bi-pin-map"></i> Zonas:</label>
                            <select wire:model="zona" class="crud-select">
                                <option value="">Selecciona una zona</option>
                                @foreach ($zonas as $zona)
                                    <option value="{{ $zona->id }}">{{ $zona->nombre }}</option>
                                @endforeach
                            </select>
                        @error('zona') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-5">
                 <div class="crud-form-group">
                        <label class="crud-form-label"><i class="bi bi-geo-alt-fill"></i> Dirección:</label>
                        <input type="text" class="crud-form-control" wire:model="direccion" style="width: 100%">
                        @error('direccion') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            <div class="text-center mt-3">
                <button type="submit" class="crud-btn crud-btn-primary"><i class="bi bi-save"></i>Crear Tiendas</button>
            </div>
        </form>
        <hr class="crud-divider">
        
        @livewire('admin.tabla-tiendas')
    </div>
</div>