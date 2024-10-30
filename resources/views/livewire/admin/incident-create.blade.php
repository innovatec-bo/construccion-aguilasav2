<div>
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Registrar incidencia</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-12 mb-4">
                    <label class="form-label" for="incidentDate">Fecha de la incidencia</label>
                    <div class="input-group input-group-sm date from">
                        <input class="form-control" id="incidentDate" type="text" value="" placeholder="dd-mm-yyyy">
                        <span class="input-group-text input-group-append" role="button">
                            <i class="ti ti-calendar"></i>
                        </span>
                    </div>
                </div>
                <div class="col-12 mb-4">
                    <label for="incidentType" class="form-label">Tipo de incidente</label>
                    <input type="text" id="incidentType" class="form-control form-control-sm">
                </div>
                <div class="col-12">
                    <label class="form-label" for="basic-default-message">Detalle</label>
                    <textarea id="basic-default-message" class="form-control" placeholder="Escriba aqui el detalle de la incidencia"></textarea>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-primary text-white" data-bs-dismiss="modal">Guardar</button>
            <button type="button" class="btn btn-sm btn-secondary text-white" wire:click="delete">Cancelar</button>
        </div>
    </div>
</div>