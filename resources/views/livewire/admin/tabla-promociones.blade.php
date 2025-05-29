<div>
    @if (session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Imagen</th>
                <th>Fecha vigencia</th>
                <th>Estatus vigencia</th>
                <th>Estatus Promocion</th>
                <th>Dias valida</th>
                <th>Horario</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($promociones as $promocion)
                <tr class="{{ $promocion->trashed() ? 'table-danger' : '' }}">
                    <td>{{ $loop->index + 1}}</td>
                    <td>{{ $promocion->nombre }}</td>
                    <td>{{ $promocion->imagen ?? '' }}</td>
                    <td>{{ $promocion->fecha_vigencia }}</td>
                    <td>
                        @if (\Carbon\Carbon::parse($promocion->fecha_vigencia)->isToday())
                            <span class="text-warning">Por caducar</span>
                        @elseif(\Carbon\Carbon::parse($promocion->fecha_vigencia)->isFuture())
                            <span class="text-success">Vigente</span>
                        @else
                            <span class="text-danger">Caducada</span>
                        @endif
                    </td>
                    <td>{{ $promocion->trashed() ? 'Inhabilitada' : 'Activa' }}</td>
                    <td>
                        @php
                            $dias = json_decode($promocion->dias_aplicables, true);
                        @endphp

                        @if (!empty($dias))
                            {{ implode(', ', $dias) }}
                        @else
                            Sin dias aplicables
                        @endif
                    </td>
                    <td>{{ $promocion->hora_inicio ? \Carbon\Carbon::parse($promocion->hora_inicio)->format('H:i') : '' }} - 
                        {{ $promocion->hora_fin ?\Carbon\Carbon::parse($promocion->hora_fin)->format('H:i') : ''  }}
                    </td>
                    <td>
                        @if ($promocion->trashed())
                            <button wire:click="restaurarPromocion({{ $promocion->id }})" class="btn btn-success btn-sm">
                                Restaurar
                            </button>
                        @else
                            <button wire:click="eliminarPromocion({{ $promocion->id }})" class="btn btn-danger btn-sm">
                                Eliminar
                            </button>
                            <button wire:click="editarPromocion({{ $promocion->id }})" class="btn btn-primary btn-sm">
                                Editar
                            </button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Paginación -->
    <div>
        {{ $promociones->links() }}
    </div>

    <!-- Modal para Editar Usuario -->
    @if($showEditModal)
        <div class="modal fade show d-block" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Promocion</h5>
                        <button type="button" class="close" wire:click="$set('showEditModal', false)">
                            &times;
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nombre:</label>
                            <input type="text" class="form-control" wire:model="nombre_promo">
                            @error('nombre_promo') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="imagen" class="form-label">Imagen</label>
                            <input class="form-control" type="file" id="img_promo" wire:model="img_promo" placeholder="Selecciona una imagen">
                            @error('img_promo') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="fecha_vigencia">Fecha vigencia</label>
                            <input type="date" id="fecha_vigencia_promo" wire:model.defer="fecha_vigencia_promo" class="form-control">
                            @error('fecha_vigencia_promo') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Estatus:</label>
                            <select class="form-control" wire:model="estatus_promo">
                                <option value="2">Selecciona estaus</option>
                                <option value="1">Activa</option>
                                <option value="0">Inhabilitada</option>
                            </select>
                            @error('estatus') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label"><i class="bi bi-calendar-check"></i> Días aplicables:</label>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($diasSemana as $dia)
                                    <div class="form-check">
                                        <input
                                            type="checkbox"
                                            id="dia-{{ $dia }}"
                                            value="{{ $dia }}"
                                            wire:model="dias_aplicables_promo"
                                            class="form-check-input"
                                        >
                                        <label class="form-check-label" for="dia-{{ $dia }}">{{ $dia }}</label>
                                    </div>
                                @endforeach
                            </div>
                            @error('estatus') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <div class="mb-3">
                                <label for="hora_inicio" class="form-label"><i class="bi bi-clock"></i> Hora de inicio:</label>
                                <input type="time" class="form-control" id="hora_inicio" wire:model="hora_inicio_promo">
                                @error('hora_inicio') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            @error('estatus') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <div class="mb-3">
                                <label for="hora_fin" class="form-label"><i class="bi bi-clock-fill"></i> Hora de fin:</label>
                                <input type="time" class="form-control" id="hora_fin" wire:model="hora_fin_promo">
                                @error('hora_fin') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            @error('estatus') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="$set('showEditModal', false)">Cerrar</button>
                        <button type="button" class="btn btn-success" wire:click="actualizarPromocion">Guardar cambios</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif
</div>