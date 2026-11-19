<div>
    @if (session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (count($movementErrors))
        <div class="alert alert-danger">
            <strong>No se pudo registrar el movimiento:</strong>
            <ul class="mb-0">
                @foreach ($movementErrors as $error)
                    <li>{{ $error['message'] }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-3 mb-3">
        <div class="col-md-4">
            <label class="form-label">Tipo de movimiento</label>
            <select class="form-select" wire:model.live="movementTypeSelected">
                @foreach ($movementTypes as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>
            @error('movementTypeSelected') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-3">
            <label class="form-label">Fecha</label>
            <div wire:ignore>
                <input type="text" id="entryDate" class="form-control" value="{{ $entryDate }}" autocomplete="off">
            </div>
            @error('entryDate') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-3">
            <label class="form-label">Proyecto (codigo)</label>
            <input type="text" class="form-control" wire:model.blur="projectCode" autocomplete="off">
            @error('projectCode') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-2">
            <label class="form-label">Desde solicitud (ID)</label>
            <div class="input-group">
                <input type="text" class="form-control" wire:model="requestId">
                <button type="button" class="btn btn-outline-secondary" wire:click="loadRequest">Cargar</button>
            </div>
            @error('requestId') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        @if ($this->needsReservation)
            <div class="col-md-3">
                <label class="form-label">Nro. de reserva</label>
                <select class="form-select" wire:model.live="reservationNumber">
                    <option value="">Seleccione...</option>
                    @foreach ($reservationOptions as $number)
                        <option value="{{ $number }}">{{ $number }}</option>
                    @endforeach
                </select>
                @error('reservationNumber') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
        @endif

        @if ($this->needsBuilderAndFiscal)
            <div class="col-md-3">
                <label class="form-label">Fiscal</label>
                <select class="form-select" wire:model="fiscalId">
                    <option value="">Seleccione...</option>
                    @foreach ($this->fiscals as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                @error('fiscalId') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-3">
                <label class="form-label">Constructor</label>
                <select class="form-select" wire:model="builderId">
                    <option value="">Seleccione...</option>
                    @foreach ($this->builders as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                @error('builderId') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
        @endif
    </div>

    <div class="row g-2 mb-3 align-items-start">
        <div class="col-md-5 position-relative">
            <input type="text" class="form-control" placeholder="Buscar material por codigo o descripcion (min. 2 letras)"
                   wire:model.live.debounce.300ms="materialSearch" autocomplete="off">
            @if ($this->materialResults->count())
                <div class="list-group position-absolute w-100 shadow" style="z-index:10; max-height:300px; overflow:auto;">
                    @foreach ($this->materialResults as $m)
                        <button type="button" class="list-group-item list-group-item-action"
                                wire:click="addMaterial({{ $m->id_mat }})" wire:key="mr-{{ $m->id_mat }}">
                            <strong>{{ $m->code_mat }}</strong> {{ $m->description_mat }}
                        </button>
                    @endforeach
                </div>
            @endif
        </div>
        <div class="col-md-7">
            <button type="button" class="btn btn-outline-primary" wire:click="showAll">Mostrar todos</button>
            <button type="button" class="btn btn-outline-secondary" wire:click="clearLines">Limpiar</button>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-sm align-middle">
            <thead>
                <tr>
                    <th>Material</th>
                    <th style="width:150px">Estado</th>
                    <th style="width:160px">Tension</th>
                    <th class="text-end">Pend. CRE</th>
                    <th class="text-end">En almacen</th>
                    <th class="text-end">Entregado (neto)</th>
                    <th style="width:150px">Cantidad</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($lines as $i => $line)
                    @php
                        $info = $this->lineInfo($line);
                        $hasError = collect($movementErrors)->contains(fn ($e) => in_array($i, $e['lines'] ?? [], true));
                    @endphp
                    <tr wire:key="{{ $line['uid'] }}" class="{{ $hasError ? 'table-danger' : '' }}">
                        <td><strong>{{ $line['code'] }}</strong><br><small>{{ $line['description'] }}</small></td>
                        <td>
                            <select class="form-select form-select-sm" wire:model.live="lines.{{ $i }}.status">
                                <option value="1">Nuevo</option>
                                <option value="2">Viejo</option>
                                <option value="3">Retirado en buen estado</option>
                                <option value="4">Indefinido</option>
                            </select>
                        </td>
                        <td>
                            <select class="form-select form-select-sm" wire:model.live="lines.{{ $i }}.tension">
                                <option value="1">Media</option>
                                <option value="2">Baja</option>
                                <option value="3">Transformador</option>
                                <option value="4">Indefinido</option>
                            </select>
                        </td>
                        <td class="text-end">{{ $info['pending'] }}</td>
                        <td class="text-end">{{ $info['available'] }}</td>
                        <td class="text-end">{{ $info['delivered'] }}</td>
                        <td>
                            <div class="input-group input-group-sm">
                                <input type="text" inputmode="decimal" class="form-control text-end" wire:model="lines.{{ $i }}.quantity">
                                <button type="button" class="btn btn-outline-secondary" title="Usar maximo" wire:click="useMax({{ $i }})">max</button>
                            </div>
                        </td>
                        <td><button type="button" class="btn btn-sm btn-outline-danger" wire:click="removeLine({{ $i }})">&times;</button></td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center text-muted">Sin materiales. Use el buscador o "Mostrar todos".</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @error('lines') <div class="text-danger small mb-2">{{ $message }}</div> @enderror

    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" id="allowEmpty" wire:model="allowEmpty">
        <label class="form-check-label" for="allowEmpty">Registrar movimiento en cero (sin materiales)</label>
    </div>

    <button type="button" class="btn btn-primary" wire:click="save" wire:loading.attr="disabled">Guardar</button>

    @script
    <script>
        const input = document.getElementById('entryDate');
        flatpickr(input, {
            dateFormat: 'd-m-Y',
            allowInput: true,
            onChange: (selected, str) => $wire.set('entryDate', str),
            onClose: (selected, str) => $wire.set('entryDate', input.value),
        });
    </script>
    @endscript
</div>