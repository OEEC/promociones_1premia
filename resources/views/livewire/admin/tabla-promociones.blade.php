<div>
    @if (session()->has('success'))
        <div class="crud-alert crud-alert-success">{{ session('success') }}</div>
    @endif

<div class="crud-promo-table">
    <div class="table-responsive">
        <table class="promo-table">
            <thead>
                <tr>
                    <th class="promo-th">#</th>
                    <th class="promo-th">Nombre</th>
                    <th class="promo-th">Imagen</th>
                    <th class="promo-th">Fecha vigencia</th>
                    <th class="promo-th">Estatus vigencia</th>
                    <th class="promo-th">Estatus Promoción</th>
                    <th class="promo-th">Días válida</th>
                    <th class="promo-th">Horario</th>
                    <th class="promo-th">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($promociones as $promocion)
                    <tr class="promo-tr {{ $promocion->trashed() ? 'promo-table-deleted' : '' }}">
                        <td class="promo-td">{{ $loop->index + 1}}</td>
                        <td class="promo-td">{{ $promocion->nombre }}</td>
                        <td class="promo-td">
                                @if($promocion->imagen)
                                    <a href="{{ asset('storage/' . $promocion->imagen) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $promocion->imagen) }}" 
                                            alt="Imagen de {{ $promocion->nombre }}" 
                                            class="promo-img-thumb">
                                    </a>
                                @else
                                    <span class="text-muted">Sin imagen</span>
                                @endif
                        </td>
                        <td class="promo-td">{{ $promocion->fecha_vigencia }}</td>
                        <td class="promo-td">
                            @if (\Carbon\Carbon::parse($promocion->fecha_vigencia)->isToday())
                                <span class="promo-badge promo-badge-warning">Por caducar</span>
                            @elseif(\Carbon\Carbon::parse($promocion->fecha_vigencia)->isFuture())
                                <span class="promo-badge promo-badge-success">Vigente</span>
                            @else
                                <span class="promo-badge promo-badge-danger">Caducada</span>
                            @endif
                        </td>
                        <td class="promo-td">
                            @if($promocion->trashed())
                                <span class="promo-badge promo-badge-danger">Inhabilitada</span>
                            @else
                                <span class="promo-badge promo-badge-success">Activa</span>
                            @endif
                        </td>
                        <td class="promo-td">
                            @php
                                $dias = json_decode($promocion->dias_aplicables, true);
                            @endphp

                            @if (!empty($dias))
                                {{ implode(', ', array_map(fn($d) => $diasSemana[$d] ?? $d, $dias)) }}
                            @else
                                Sin dias aplicables
                            @endif
                        </td>
                        <td class="promo-td">
                            {{ $promocion->hora_inicio ? \Carbon\Carbon::parse($promocion->hora_inicio)->format('H:i') : '' }} - 
                            {{ $promocion->hora_fin ? \Carbon\Carbon::parse($promocion->hora_fin)->format('H:i') : '' }}
                        </td>
                        <td class="promo-td">
                            <div class="promo-btn-group">
                                @if ($promocion->trashed())
                                    <button wire:click="restaurarPromocion({{ $promocion->id }})" class="promo-btn promo-btn-success promo-btn-sm">
                                        <i class="bi bi-recycle"></i> Restaurar
                                    </button>
                                @else
                                    <button wire:click="eliminarPromocion({{ $promocion->id }})" class="promo-btn promo-btn-danger promo-btn-sm">
                                        <i class="bi bi-trash"></i> Eliminar
                                    </button>
                                    <button wire:click="editarPromocion({{ $promocion->id }})" class="promo-btn promo-btn-primary promo-btn-sm">
                                        <i class="bi bi-pencil-square"></i> Editar
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div class="promo-pagination">
        {{ $promociones->links() }}
    </div>
</div>

    <!-- Modal para Editar Promoción con estilos encapsulados -->
    <div class="promo-modal-container">
        @if($showEditModal)
            <div class="modal fade show d-block" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Editar Promoción</h5>
                            <button type="button" class="modal-close" wire:click="$set('showEditModal', false)">
                                &times;
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="promo-form-group">
                                <label class="promo-form-label">
                                    <i class="bi bi-pencil-fill"></i> Nombre:
                                </label>
                                <input type="text" class="promo-form-control" wire:model="nombre_promo">
                                @error('nombre_promo') <span class="promo-error">{{ $message }}</span> @enderror
                            </div>
                            <div class="promo-form-group">
                                <label class="promo-form-label">
                                    <i class="bi bi-image-fill"></i> Imagen:
                                </label>

                                {{-- Imagen actual --}}
                                @if($img_actual_promo)
                                    <div class="mb-2">
                                        <p class="text-muted">Imagen actual:</p>
                                        <img src="{{ asset('storage/' . $img_actual_promo) }}" 
                                            alt="Imagen actual de {{ $nombre_promo }}" 
                                            class="promo-img-preview"
                                            width="50%" height="75%">
                                    </div>
                                @endif

                                {{-- Nueva imagen subida --}}
                                @if($img_promo)
                                    <div class="mb-2">
                                        <p class="text-muted">Nueva imagen (preview):</p>
                                        <img src="{{ $img_promo->temporaryUrl() }}" 
                                            alt="Preview nueva imagen"
                                            width="50%" height="75%">
                                    </div>
                                @endif

                                {{-- Input de carga --}}
                                <input class="promo-form-control" type="file" id="img_promo" wire:model="img_promo" accept="image/*">
                                @error('img_promo') <span class="promo-error">{{ $message }}</span> @enderror
                            </div>
                            <div class="promo-form-group">
                                <label class="promo-form-label">
                                    <i class="bi bi-calendar-event"></i> Fecha vigencia:
                                </label>
                                <input type="date" id="fecha_vigencia_promo" wire:model.defer="fecha_vigencia_promo" class="promo-form-control">
                                @error('fecha_vigencia_promo') <span class="promo-error">{{ $message }}</span> @enderror
                            </div>
                            <div class="promo-form-group">
                                <label class="promo-form-label">
                                    <i class="bi bi-gear-fill"></i> Estatus:
                                </label>
                                <select class="promo-form-select" wire:model="estatus_promo">
                                    <option value="2">Selecciona estatus</option>
                                    <option value="1">Activa</option>
                                    <option value="0">Inhabilitada</option>
                                </select>
                                @error('estatus_promo') <span class="promo-error">{{ $message }}</span> @enderror
                            </div>
                            <div class="promo-form-group">
                                <label class="promo-form-label">
                                    <i class="bi bi-calendar-check"></i> Días aplicables:
                                </label>
                                <div class="promo-checkbox-group">
                                    @foreach($diasSemana as $key => $dia)
                                        <label class="promo-form-check">
                                            <input type="checkbox" id="dia-{{ $dia }}" value="{{ $key }}" wire:model="dias_aplicables_promo" class="promo-form-check-input">
                                            <span class="promo-checkmark"></span>
                                            <span class="promo-form-check-label">{{ $dia }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                @error('dias_aplicables_promo') <span class="promo-error">{{ $message }}</span> @enderror
                            </div>
                            <div class="promo-form-group">
                                <label class="promo-form-label">
                                    <i class="bi bi-clock"></i> Hora de inicio:
                                </label>
                                <input type="time" class="promo-form-control" id="hora_inicio" wire:model="hora_inicio_promo">
                                @error('hora_inicio_promo') <span class="promo-error">{{ $message }}</span> @enderror
                            </div>
                            <div class="promo-form-group">
                                <label class="promo-form-label">
                                    <i class="bi bi-clock-fill"></i> Hora de fin:
                                </label>
                                <input type="time" class="promo-form-control" id="hora_fin" wire:model="hora_fin_promo">
                                @error('hora_fin_promo') <span class="promo-error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="promo-btn promo-btn-secondary" wire:click="$set('showEditModal', false)">
                                <i class="bi bi-x-circle"></i> Cerrar
                            </button>
                            <button type="button" class="promo-btn promo-btn-success" wire:click="actualizarPromocion">
                                <i class="bi bi-check-circle"></i> Guardar cambios
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-backdrop fade show"></div>
        @endif
    </div>
</div>