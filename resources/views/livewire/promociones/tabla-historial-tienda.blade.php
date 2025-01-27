<div>
    <h3 class="color-encabezado"><b>Historial de Promociones Canjeadas</b></h3>
    @if ($promocionesCanjeadas->isEmpty())
        <p>No hay promociones canjeadas.</p>
    @else
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th class="bg-dark text-white" scope="col">#</th>
                    <th class="bg-dark text-white" scope="col">Fecha de Canje</th>
                    <th class="bg-dark text-white" scope="col">No Tarjeta</th>
                    <th class="bg-dark text-white" scope="col">Nombre Cliente</th>
                    <th class="bg-dark text-white" scope="col">Promoción</th>
                    <th class="bg-dark text-white" scope="col">Empleado</th>
                    <th class="bg-dark text-white" scope="col">Tienda</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($promocionesCanjeadas as $canje)
                    <tr>
                        <th scope="row">{{ $loop->index + 1 }}</th>
                        <td>{{ $canje->created_at }}</td>
                        <td>{{ $canje->cliente->no_tarjeta }}</td>
                        <td>{{ $canje->cliente->persona->nombre }} {{ $canje->cliente->persona->apellido_paterno }} {{ $canje->cliente->persona->apellido_materno }}</td>
                        <td>{{ $canje->promocion->nombre }}</td>
                        <td>{{ $canje->empleado->persona->nombre }} {{ $canje->empleado->persona->apellido_paterno }} {{ $canje->empleado->persona->apellido_materno }}</td>
                        <td>{{ $canje->tienda->nombre }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>