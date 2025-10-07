<div>
    <h3 class="color-encabezado"><b><i class="bi bi-list-stars"></i> Historial de Promociones Canjeadas</b></h3>
    @if ($promocionesCanjeadas->isEmpty())
        <p>No hay promociones canjeadas.</p>
    @else
     <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Fecha de Canje</th>
                    <th>No Tarjeta</th>
                    <th>Nombre Cliente</th>
                    <th>Promoción</th>
                    <th>Empleado</th>
                    <th>Tienda</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($promocionesCanjeadas as $canje)
                    <tr>
                        <th scope="row">{{ $loop->index + 1 }}</th>
                        <td>{{ $canje->created_at }}</td>
                        <td>{{ $canje->cliente->no_tarjeta }}</td>
                        <td>{{ $canje->cliente->persona->nombre_completo }}</td>
                        <td>{{ $canje->promocion->nombre }}</td>
                        <td>{{ $canje->empleado->persona->nombre_completo }}</td>
                        <td>{{ $canje->tienda->nombre }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        @if($promocionesCanjeadas->hasPages())
            {{ $promocionesCanjeadas->links() }} <!-- 👈 Esto genera la paginación -->
        @endif
    </div>
    @endif
</div>