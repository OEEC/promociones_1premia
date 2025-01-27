<div>
 <h3 class="color-encabezado"><b>Promociones Canjeadas</b></h3>
    @if (Count($promocionesCanjeadas) == 0)
        <p>No hay promociones canjeadas.</p>
    @else
     <h5 class="color-encabezado">Cliente: {{$cliente->persona->nombre}} {{$cliente->persona->apellido_paterno}} {{$cliente->persona->apellido_materno}}</h5>
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
                        <td>{{ $canje->empleado->persona->nombre ?? ' ' }}  {{ $canje->empleado->persona->apellido_paterno ?? ' '}}</td>
                        <td>{{ $canje->tienda->nombre ?? ' ' }}</td>
                        <td>{{ $canje->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
