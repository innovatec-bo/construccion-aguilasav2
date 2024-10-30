<div>
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Registrar incidencia</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-12 mb-4">
                    <label class="form-label" for="projectList">Proyecto(s)</label>
                    <textarea id="projectList" wire:model.live="projectList" class="form-control form-control-sm" placeholder="proyecto1,proyecto2,proyecto3"></textarea>
                    <div class="form-text">Especifique aqu&iacute; el proyecto o los proyectos a los que se aplicar&aacute; esta incidencia.</div>
                </div>
                <div class="col-12 mb-4">
                    <label class="form-label" for="incidentDate">Fecha de la incidencia</label>
                    <div class="input-group input-group-sm date">
                        <input class="form-control" id="incidentDate" type="text" value="" placeholder="dd-mm-yyyy">
                        <span class="input-group-text input-group-append" role="button">
                            <i class="ti ti-calendar"></i>
                        </span>
                    </div>
                </div>
                <div class="col-12 mb-4">
                    <label for="incidentType" class="form-label">Tipo de incidente</label>
                    <select class="form-select form-select-sm" id="incidentType" wire:model.live="incidentType" aria-label="Default select example">
                        <option selected=""></option>
                        @foreach ($incidentTypeList as $key => $name)
                            <option value="{{$key}}">{{$name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label" for="incidentDetail">Detalle</label>
                    <textarea id="incidentDetail" wire:model.live="incidentDetail" class="form-control form-control-sm" placeholder="Escriba aqui el detalle de la incidencia"></textarea>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-primary text-white" wire:click="save">Guardar</button>
            <button type="button" class="btn btn-sm btn-secondary text-white" data-bs-dismiss="modal">Cancelar</button>
        </div>
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
            format: 'dd-mm-yyyy',
            autoclose: true,
            clearBtn: true,
            container: ".modal-body"
        });
        $('.input-group.date').on('changeDate', function(e) {
            let date = null;
            if (e.date !== undefined) 
            {
                date = moment(e.date).format('DD-MM-YYYY');
            }
            @this.incidentDate = date;
            @this.triggerLoading();
        });
</script>
@endscript