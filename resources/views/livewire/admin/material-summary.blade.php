<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow-lg">
            
            <div class="card-header">
                <div class="row">
                    <div class="form-check col-2">
                        <input type="checkbox" class="form-check-input" id="groupByProject" wire:model="groupByProject">
                        <label class="form-check-label" for="groupByProject">Agrupar por proyecto <i  id="popover" class="fas fa-info-circle"></i></label>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-2">
                        <label for="projectCode" class="mb-0">Proyecto</label>
                        <input type="text" class="form-control" wire:model.debounce.1500ms="projectCode" id="projectCode" placeholder="Codigo proyecto">
                    </div>
                    <div class="form-group col-2">
                        <label for="projectStatusId" class="mb-0">Estado</label>
                        <select class="form-control" wire:model.debounce.1500ms="projectStatusId" id="projectStatusId">
                            <option value="">Estado del proyecto</option>
                            @foreach ($projectStatus as $status)
                                <option value="{{$status->id_pst}}">{{$status->status_name_pst}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-2">
                        <label for="materialCode" class="mb-0">Mat. Codigo</label>
                        <input type="text" class="form-control"  wire:model.debounce.1500ms="materialCode" id="materialCode" placeholder="Codigo material">
                    </div>
                    <div class="form-group col-2">
                        <label for="search" class="mb-0">Mat. Descripcion</label>
                        <input type="text" class="form-control"  wire:model.debounce.1500ms="search" id="search" placeholder="Descripcion material">
                    </div>
                    <div class="form-group col-2">
                        <button type="button" class="btn btn-primary mt-4">Quitar filtros</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="overlay dark d-none" wire:loading.class="d-flex"
                    wire:target="previousPage, nextPage, gotoPage, search,groupByProject,projectCode,projectStatusId,materialCode">
                    <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover table-sm">
                        <thead>
                            <tr class="text-center">
                                <th>C&oacute;digo</th>
                                <th>Descripci&oacute;n</th>
                                <th>Proyecto</th>
                                <th>Cantidad<br>Comprometida</th>
                                <th>Retirado<br>de CRE</th>
                                <th>Pendiente por<br>retirar de CRE</th>
                                <th>Entregado<br>al construcor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($materialSummaries as $materialSummary)
                                <tr>
                                    <td class="stacked-info">
                                        {{ $materialSummary->material_code }}
                                        
                                    </td>
                                    <td>
                                        {{ $materialSummary->material_description }}
                                    </td>
                                    <td class="stacked-info">
                                        {{ $materialSummary->project_code }}
                                        <p class="mb-0 text-warning">{{ $materialSummary->project_status_name }}</p>
                                    </td>
                                    <td class="text-right"> 
                                        {{ number_format($materialSummary->quantity_assigned_materials,'2','.',',') }} 
                                    </td>
                                    <td class="text-right">
                                        {{ number_format($materialSummary->quantity_picked_up_from_cre,'2','.',',') }}
                                    </td>
                                    <td class="text-right"> 
                                        {{ number_format($materialSummary->pending_material_in_cre,'2','.',',') }}
                                    </td>
                                    <td class="text-right"> 
                                        {{ number_format($materialSummary->quantity_materials_delivered_to_builder,'2','.',',') }} 
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer clearfix">
                <div class="table-responsive">
                    {{ $materialSummaries->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
