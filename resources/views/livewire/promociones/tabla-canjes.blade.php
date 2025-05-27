<div>
 <h3 class="color-encabezado"><b><i class="bi bi-card-checklist"></i> Promociones canjeadas</b></h3>
   <h5 class="color-encabezado">Cliente: {{$cliente->persona->nombre_completo }}</h5>
    @if (Count($promocionesCanjeadas) == 0)
        <p>No hay promociones canjeadas.</p>
    @else
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th class="bg-dark text-white" scope="col">#</th>
                    <th class="bg-dark text-white" scope="col">Promoción</th>
                    <th class="bg-dark text-white" scope="col">Quien realizó</th>
                    <th class="bg-dark text-white" scope="col">Tienda</th>
                    <th class="bg-dark text-white" scope="col">Fecha de Canje</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($promocionesCanjeadas as $canje)
                    <tr>
                        <th scope="row">{{ $loop->index + 1}}</th>
                        <td>{{ $canje->promocion->nombre }}</td>
                        <td>{{ $canje->empleado->persona->nombre_completo ?? ' ' }} </td>
                        <td>{{ $canje->tienda->nombre ?? ' ' }}</td>
                        <td>{{ $canje->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
