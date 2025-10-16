<div class="reportes-module container-fluid p-4">
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-file-earmark-bar-graph"></i> Reporte de Promociones Canjeadas</h5>
        </div>

        <div class="card-body bg-light-subtle">
            {{-- FILTROS --}}
            <div class="row g-3 mb-3">
                <div class="col-md-3">
                    <label class="form-label fw-bold text-secondary">Fecha Inicio</label>
                    <input type="date" class="form-control" wire:model="fecha_inicio">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold text-secondary">Fecha Fin</label>
                    <input type="date" class="form-control" wire:model="fecha_fin">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold text-secondary">No. Tarjeta</label>
                    <input type="text" class="form-control" placeholder="Ej. 123456" wire:model.defer="no_tarjeta">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold text-secondary">Nombre Cliente</label>
                    <input type="text" class="form-control" placeholder="Ej. Juan Pérez" wire:model.defer="nombre_cliente">
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label fw-bold text-secondary">Promoción</label>
                    <select class="form-select" wire:model="promocion">
                        <option value="0">-- Todas --</option>
                        @foreach ($promociones as $promo)
                            <option value="{{ $promo->id }}">{{ $promo->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold text-secondary">Empleado</label>
                    <input type="text" class="form-control" placeholder="Ej. Ana López" wire:model.defer="empleado">
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold text-secondary">Tienda</label>
                    <select class="form-select" wire:model="tienda">
                        <option value="0">-- Todas --</option>
                        @foreach ($tiendas as $t)
                            <option value="{{ $t->id }}">{{ $t->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <button class="btn btn-primary" wire:click="filtrar">
                    <i class="bi bi-funnel"></i> Aplicar Filtros
                </button>
                <button class="btn btn-outline-secondary" wire:click="limpiarFiltros">
                    <i class="bi bi-arrow-counterclockwise"></i> Limpiar
                </button>
            </div>
            <div class="text-end mt-3">
                <button wire:click="exportarExcel" class="btn btn-success me-2">
                    <i class="bi bi-file-earmark-excel"></i> Reporte general de canjes
                </button>
                <button wire:click="exportarResumenTiendas" class="btn btn-success">
                    <i class="bi bi-file-earmark-excel"></i> Total de canjes en tiendas
                </button>
                <button wire:click="exportarPromocionesMasCanjeadas" class="btn btn-success">
                    <i class="bi bi-file-earmark-excel"></i> Promociones más Canjeadas
                </button>
            </div>
        </div>
    </div>

    {{-- TABLA DE RESULTADOS --}}
    <div class="mt-4">
        <livewire:admin.tabla-reportes />
    </div>
</div>

@push('styles')
<style>
    .reportes-module .card-header {
        border-bottom: 2px solid #198754;
    }

    .reportes-module .form-label {
        font-size: 0.9rem;
    }

    .reportes-module .form-control,
    .reportes-module .form-select {
        border-radius: 0.5rem;
    }

    .reportes-module .btn {
        border-radius: 0.5rem;
        transition: all 0.2s ease-in-out;
    }

    .reportes-module .btn:hover {
        transform: scale(1.03);
    }
</style>
@endpush
