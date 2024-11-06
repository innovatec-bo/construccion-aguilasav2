<div>
    <div class="modal-header">
        <h5 class="modal-title">Crear contrato</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <form>
            <div class="form-group mb-3">
                <label class="form-label" for="number">N&uacute;mero</label>
                <input type="text" id="number" class="form-control form-control-sm" wire:model.live="number" placeholder="Numero de contrato">
                @error('number')
                    <span class="text-danger small"> {{$message}} </span>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label class="form-label" for="amount">Monto</label>
                <input type="text" id="amount" class="form-control form-control-sm" wire:model.live="amount" placeholder="Monto">
                @error('amount')
                    <span class="text-danger small"> {{$message}} </span>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label class="form-label">Desde {{$from}}</label>
                <div class="input-group date from">
                    <input class="form-control form-control-sm" type="text" value="" placeholder="dd/mm/yyyy">
                    <span class="input-group-text input-group-append" id="basic-addon2"><i class="fa fa-calendar"></i></span>
                </div>
                @error('from')
                    <span class="text-danger small"> {{$message}} </span>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label class="form-label">Hasta</label>
                <div class="input-group date to">
                    <input class="form-control form-control-sm" type="text" value="" placeholder="dd/mm/yyyy">
                    <span class="input-group-text input-group-append" id="basic-addon2"><i class="fa fa-calendar"></i></span>
                </div>
                @error('to')
                    <span class="text-danger small"> {{$message}} </span>
                @enderror
            </div>
            
            <div class="form-group mb-3">
                <label class="form-label" for="amount">UMBO</label>
                <input type="text" id="umbo" class="form-control form-control-sm" wire:model.live="umbo" placeholder="umbo">
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
@assets
<link rel="stylesheet" href="{{asset('js/bootstrap-datepicker-1.9.0/css/bootstrap-datepicker3.css')}}">
<script src="{{asset('js/bootstrap-datepicker-1.9.0/locales/bootstrap-datepicker.es.min.js')}}" defer></script>
<script src="{{asset('js/bootstrap-datepicker-1.9.0/js/bootstrap-datepicker.js')}}" defer></script>
@endassets
@script
<script>
    $('.input-group.date').datepicker({
        language: "es",
        format: 'dd/mm/yyyy',
        autoclose: true,
        container: ".modal-body"
    });

    $('.input-group.date').on('changeDate', function(e) {
        let date = null;
        if (e.date !== undefined) 
        {
            date = moment(e.date).format('DD/MM/YYYY');
        }
        if ($(this).hasClass('from')) 
        {
            @this.from = date;
            @this.triggerLoading();
        } 
        else 
        {
            @this.to = date;
            @this.triggerLoading();
        }
    });
</script>
@endscript