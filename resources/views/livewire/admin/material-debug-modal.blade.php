<div class="modal-dialog position-relative">
    <div class="overlay d-none" wire:loading.class="d-flex" wire:target="debug">
        <div class="spinner-grow" style="width: 3rem; height: 3rem;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Depurar materiales</h5>
            {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
        </div>
        <div class="modal-body">
            <p>
                Esta operaci&oacute;n crea un movimiento llamado <strong>Depuraci&oacute;n</strong> que pone en cero los materiales pendientes de retiro en CRE
            </p>
            <p>Se depuraran los proyectos que se encuentren en los siguientes estados:</p>
            <ol>
                @foreach ($statusToDebug as $status)
                    <li>{{$status->status_name_pst}}</li>                
                @endforeach
            </ol>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary" wire:click="debug">Aplicar depuraci&oacute;n</button>
        </div>
    </div>
</div>