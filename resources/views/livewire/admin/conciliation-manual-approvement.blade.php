<div>
    <div class="modal-content position-relative">
        <div class="overlay d-none" wire:loading.class="d-flex" wire:target="save">
            <div class="spinner-grow" style="width: 3rem; height: 3rem;" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <div class="modal-header">
            <h5 class="modal-title">Aprobacion manual de conciliaci&oacute;n</h5>
        </div>
        <div class="modal-body">
            <p>
                Esta opci&oacute;n da control al encargado de almac&eacute;n para definir que proyectos estan aptos para pasar de recepci&oacute;n de conciliaci&oacute;n a env&iacute;o de conciliaci&oacute;n.
            </p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary" wire:click="save">Aprobar</button>
        </div>
    </div>
</div>