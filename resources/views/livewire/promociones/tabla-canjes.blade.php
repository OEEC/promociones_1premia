<div class="card shadow-sm">
    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-card-checklist"></i> Promociones canjeadas</h5>
    </div>
    <div class="card-body">
        <h6 class="mb-3 text-secondary">
            <i class="bi bi-person-circle"></i> Cliente:
            <span class="fw-bold text-white">{{ $cliente->persona->nombre_completo }}</span>
        </h6>

        @if (count($promocionesCanjeadas) == 0)
            <p class="text-muted">No hay promociones canjeadas.</p>
        @else
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Promoción</th>
                            <th>Quien realizó</th>
                            <th>Tienda</th>
                            <th>Fecha de canje</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($promocionesCanjeadas as $canje)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $canje->promocion->nombre }}</td>
                                <td>{{ $canje->empleado->persona->nombre_completo ?? '-' }}</td>
                                <td>{{ $canje->tienda->nombre ?? '-' }}</td>
                                <td>{{ $canje->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($promocionesCanjeadas->hasPages())
                <div class="mt-4">
                    {{ $promocionesCanjeadas->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
