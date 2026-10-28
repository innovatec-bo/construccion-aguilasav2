<form wire:submit="save" class="row g-6">
    <!-- Navigation -->
    <div class="col-12 col-lg-4">
        <div class="d-flex justify-content-between flex-column mb-4 mb-md-0">
            <h5 class="mb-4">Configuraci&oacute;n</h5>
            <ul class="nav nav-align-left nav-pills flex-column">
                <li class="nav-item mb-1">
                    <a class="nav-link waves-effect waves-light" href="{{route('admin.settings.system')}}">
                        <i class="icon-base ti tabler-shopping-cart icon-sm me-1_5"></i>
                        <span class="align-middle">Sistema</span>
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link active waves-effect waves-light" href="javascript:void(0);">
                        <i class="icon-base ti tabler-rosette-discount icon-sm me-1_5"></i>
                        <span class="align-middle">Administraci&oacute;n de estados</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <!-- /Navigation -->

    <!-- Options -->
    <div class="col-12 col-lg-8 pt-6 pt-lg-0">
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="tab-content p-0">
            <div class="tab-pane fade show active" id="checkout" role="tabpanel">
                <!-- Tarjeta 1: Aprobación manual de conciliación -->
                <div class="card mb-6">
                    <div class="card-header">
                        <div class="card-title m-0">
                            <h5 class="m-0">Aprobación manual de conciliación</h5>
                            <p class="my-0 card-subtitle">Esta opción da control al encargado de almacén para definir
                                qué proyectos están aptos para pasar de recepción de conciliación a envío de
                                conciliación.</p>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="form-check my-2 ms-2">
                            <input class="form-check-input" type="radio" 
                                wire:model.boolean="enableManualApprovementForConciliations" 
                                name="enableManualApprovementForConciliations" 
                                id="manualApprovementTrue" 
                                value="true">
                            <label class="form-check-label text-heading" for="manualApprovementTrue"> Activado </label>
                        </div>
                        <div class="form-check mb-6 mt-4 ms-2">
                            <input class="form-check-input" type="radio" 
                                wire:model.boolean="enableManualApprovementForConciliations" 
                                name="enableManualApprovementForConciliations" 
                                id="manualApprovementFalse" 
                                value="false">
                            <label class="form-check-label text-heading" for="manualApprovementFalse"> Desactivado </label>
                        </div>
                        @error('enableManualApprovementForConciliations')
                            <span class="text-danger small ms-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Tarjeta 2: Denegar As Built CRE -->
                <div class="card mb-6">
                    <div class="card-header">
                        <div class="card-title m-0">
                            <h5 class="m-0">Denegar As Built si existen materiales pendientes de retiro en CRE</h5>
                            <p class="my-0 card-subtitle">Con esta opción habilitada, se niega el pase a As Built para
                                todos los proyectos que tengan materiales pendientes de retiro en CRE.</p>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="form-check my-2 ms-2">
                            <input class="form-check-input" type="radio" 
                                wire:model.boolean="noPendingMaterialsInCreForAsBuilt" 
                                name="noPendingMaterialsInCreForAsBuilt" 
                                id="creMaterialsTrue" 
                                value="true">
                            <label class="form-check-label text-heading" for="creMaterialsTrue"> Activado </label>
                        </div>
                        <div class="form-check mb-6 mt-4 ms-2">
                            <input class="form-check-input" type="radio" 
                                wire:model.boolean="noPendingMaterialsInCreForAsBuilt" 
                                name="noPendingMaterialsInCreForAsBuilt" 
                                id="creMaterialsFalse" 
                                value="false">
                            <label class="form-check-label text-heading" for="creMaterialsFalse"> Desactivado </label>
                        </div>
                        @error('noPendingMaterialsInCreForAsBuilt')
                            <span class="text-danger small ms-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-4">
                    <button type="submit" class="btn btn-primary waves-effect waves-light" wire:loading.attr="disabled">
                        <span wire:loading.remove>Guardar cambios</span>
                        <span wire:loading>Guardando...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Options-->
</form>