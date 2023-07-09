<div class="modal-dialog modal-dialog-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Editar contrato {{$contract->contract_number_con}}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form>
                <div class="form-group">
                    <label for="number">N&uacute;mero</label>
                    <input type="text" id="number" class="form-control" wire:model.lazy="number" placeholder="Numero de contrato">
                    @error('number')
                        <span class="text-danger small"> {{$message}} </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="amount">Monto</label>
                    <input type="text" id="amount" class="form-control" wire:model.lazy="amount" placeholder="Monto">
                    @error('amount')
                        <span class="text-danger small"> {{$message}} </span>
                    @enderror
                </div>
                <label>Desde</label>
                <div class="input-group date from">
                    <input class="form-control" type="text" value="{{$contract->start_date_con->format('d/m/Y')}}" placeholder="dd/mm/yyyy">
                    <span class="input-group-text input-group-append" id="basic-addon2"><i class="fa fa-calendar"></i></span>
                </div>
                @error('from')
                    <span class="text-danger small"> {{$message}} </span>
                @enderror
                
                <label>Hasta</label>
                <div class="input-group date from">
                    <input class="form-control" type="text" value="{{$contract->expiration_date_con->format('d/m/Y')}}" placeholder="dd/mm/yyyy">
                    <span class="input-group-text input-group-append" id="basic-addon2"><i class="fa fa-calendar"></i></span>
                </div>
                @error('to')
                    <span class="text-danger small"> {{$message}} </span>
                @enderror
                <div class="form-group">
                    <label for="amount">UMBO</label>
                    <input type="text" id="umbo" class="form-control" value="" placeholder="umbo">
                    @error('umbo')
                        <span class="text-danger small"> {{$message}} </span>
                    @enderror
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary" wire:click="save">Guardar</button>
        </div>
    </div>
    <script>
        $(function() {

            $('.input-group.date').datepicker({
                language: "es",
                format: 'dd-mm-yyyy',
                autoclose: true,
            });

            $('.input-group.date').on('changeDate', function(e) {
                let date = null;
                if (e.date !== undefined) 
                {
                    date = moment(e.date).format('DD/MM/YYYY');
                }
                if ($(this).hasClass('from')) 
                {
                    Livewire.emit('fromChanged', date); 
                    console.log(date);  
                } 
                else 
                {
                    Livewire.emit('toChanged', date);
                }
            });
        });
    </script>
</div>
