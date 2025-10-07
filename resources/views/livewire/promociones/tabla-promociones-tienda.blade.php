<div>
    <h3 class="color-encabezado"><b><i class="bi bi-list-stars"></i> LISTADO DE PROMOCIÓNES</b></h3>
    @if ($promociones->isEmpty())
        <p>No hay promociones</p>
    @else
     <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Promocion</th>
                    <th>Imagen</th>
                    <th>Fecha Vigencia</th>
                    <th>Estatus vigencia</th>
                    <th>Dias valida</th>
                    <th>Horario</th>
                    <th>Estatus Promocion</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($promociones as $promo)
                    <tr>
                        <th scope="row">{{ $loop->index + 1 }}</th>
                        <td>{{ $promo->nombre }}</td>
                        <td class="promo-td">
                                @if($promo->imagen)
                                    <a href="{{ asset('storage/' . $promo->imagen) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $promo->imagen) }}" 
                                            alt="Imagen de {{ $promo->nombre }}" 
                                            class="promo-img-thumb">
                                    </a>
                                @else
                                    <span class="text-muted">Sin imagen</span>
                                @endif
                        </td>
                        <td>{{ $promo->fecha_vigencia }}</td>
                        <td>
                            @if($promo?->fecha_vigencia)
                                @if (\Carbon\Carbon::parse($promo->fecha_vigencia)->isToday())
                                    <span class="text-warning">Por caducar</span>
                                @elseif(\Carbon\Carbon::parse($promo->fecha_vigencia)->isFuture())
                                    <span class="text-success">Vigente</span>
                                @else
                                    <span class="text-danger">Caducada</span>
                                @endif
                            @else
                                <span class="text-danger">N/A</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $dias = json_decode($promo->dias_aplicables, true);
                            @endphp

                            @if (!empty($dias))
                                {{ implode(', ', array_map(fn($d) => $diasSemana[$d] ?? $d, $dias)) }}
                            @else
                                Sin dias aplicables
                            @endif
                        </td>
                        <td>{{ $promo->hora_inicio ? \Carbon\Carbon::parse($promo->hora_inicio)->format('H:i') : '' }} - 
                            {{ $promo->hora_fin ?\Carbon\Carbon::parse($promo->hora_fin)->format('H:i') : ''  }}
                        </td>
                        <td>{{ $promo->estatus ? 'Activa' : 'Inhabilitada' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
     </div>
    @endif
</div>