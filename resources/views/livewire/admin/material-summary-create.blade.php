<div class="card shadow-lg">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12 mb-3">
                <a class="btn btn-secondary mx-1" href="#">Cancelar</a>
                <button class="btn btn-primary" wire:click="save">Guardar</button>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Tipo de movimiento</label>
                    <select class="form-select" wire:model.live="movementTypeSelected">
                        @foreach ($movementTypes as $row)
                            <option value="{{$row->id_mqt}}">{{$row->name_mqt}}</option>
                        @endforeach
                    </select>
                    @error('movementTypeSelected')
                        <span class="text-danger small"> {{ $message }} </span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-2">
                <div class="form-group">
                    <label>ID de solicitud</label>
                    <input type="text" class="form-control" wire:model.live="requestId">
                    @error('requestId')
                        <span class="text-danger small"> {{ $message }} </span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Fiscal</label>
                    <input type="text" class="form-control" wire:model.live="fiscal">
                    @error('fiscal')
                        <span class="text-danger small"> {{ $message }} </span>
                    @enderror
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Constructor</label>
                    <input type="text" class="form-control" wire:model.live="builder">
                    @error('builder')
                        <span class="text-danger small"> {{ $message }} </span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-2">
                <label>Fecha</label>
                <div class="input-group date manual-entry-date">
                    <input class="form-control" type="text" value="" placeholder="dd-mm-yyyy">
                    <span class="input-group-text input-group-append" id="basic-addon2"><i class="fa fa-calendar"></i></span>
                </div>
                @error('manualEntryDate')
                    <span class="text-danger small"> {{ $message }} </span>
                @enderror
            </div>
            <div class="col-md-2">
                <label>Proyecto</label>
                <input class="form-control" type="text" value="" wire:model.live="project">
                @error('project')
                    <span class="text-danger small"> {{ $message }} </span>
                @enderror
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="amount">Nro. de reserva</label>
                    <select class="form-select" wire:model.live="reservationNumber">
                        <option value="a">45454</option>
                        <option value="b">45454232</option>
                    </select>
                    @error('reservationNumber')
                        <span class="text-danger small"> {{ $message }} </span>
                    @enderror
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-hover table-striped table-sm small">
            <tfoot>
                <th>COD</th>
                <th>Descripci&oacute;n</th>
                <th>Comprometido<br>de CRE</th>
                <th>Total<br>retirado<br>de CRE</th>
                <th>Saldo por<br>retirar de CRE</th>
                <th>Entregado al<br>constructor<br><em>Prestamos incluidos</em></th>
                <th>Comprometido<br>en SEREBO</th>
                <th>Disponible<br>en almac&eacute;n</th>
                <th>Movimiento</th>
                <th>Tensi&oacute;n</th>
                <th>Estado</th>
                <th>X</th>
            </tfoot>
            <tbody></tbody>
        </table>
    </div>
    <div class="card-footer">

    </div>
</div>
@push('scripts')
    <script>
        $(function() {
            $('.input-group.date').datepicker({
                language: "es",
                format: 'dd-mm-yyyy',
                autoclose: true,
                orientation: "bottom auto"
            });
            $('.input-group.date').on('changeDate', function(e) {
                let date = null;
                date = moment(e.date).format('DD-MM-YYYY');
                Livewire.emit('manualEntryDateChanged', date); 
            });
        });
    </script>
@endpush
