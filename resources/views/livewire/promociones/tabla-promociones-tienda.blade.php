<div>
    <h3 class="color-encabezado"><b><i class="bi bi-list-stars"></i> LISTADO DE PROMOCIÓNES</b></h3>
    @if ($promociones->isEmpty())
        <p>No hay promociones</p>
    @else
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th class="bg-dark text-white" scope="col">#</th>
                    <th class="bg-dark text-white" scope="col">Promocion</th>
                    <th class="bg-dark text-white" scope="col">Fecha Vigencia</th>
                    <th class="bg-dark text-white" scope="col">Estatus vigencia</th>
                    <th class="bg-dark text-white" scope="col">Estatus Promocion</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($promociones as $promo)
                    <tr>
                        <th scope="row">{{ $loop->index + 1 }}</th>
                        <td>{{ $promo->nombre }}</td>
                        <td>{{ $promo->fecha_vigencia }}</td>
                        <td>
                            @if (\Carbon\Carbon::parse($promocion->fecha_vigencia)->isToday())
                                <span class="text-warning">Por caducar</span>
                            @elseif(\Carbon\Carbon::parse($promocion->fecha_vigencia)->isFuture())
                                <span class="text-success">Vigente</span>
                            @else
                                <span class="text-danger">Caducada</span>
                            @endif
                        </td>
                        <td>{{ $promo->estatus ? 'Inhabilitada' : 'Activa' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>