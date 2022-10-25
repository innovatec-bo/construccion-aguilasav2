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
                        <select class="form-control" wire:model="projectStatusId" id="projectStatusId">
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
                        <button type="button" wire:click="resetFilters" class="btn btn-primary mt-4">Quitar filtros</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="overlay dark d-none" wire:loading.class="d-flex"
                    wire:target="previousPage, nextPage, gotoPage, search,groupByProject,projectCode,projectStatusId,materialCode,resetFilters,order">
                    <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover table-sm">
                        <thead>
                            <tr class="text-center">
                                <th wire:click="order('material_code')" role="button">
                                    C&oacute;digo
                                    <div class="float-right">
                                        @if ($sort == 'material_code')
                                            @if ($direction == 'asc')
                                                <i class="fas fa-sort-up"></i>
                                            @else
                                                <i class="fas fa-sort-down"></i>
                                            @endif
                                        @else
                                            <i class="fas fa-sort"></i>
                                        @endif
                                    </div>
                                    
                                </th>
                                <th wire:click="order('material_description')" role="button">
                                    Descripci&oacute;n
                                    <div class="float-right">
                                        @if ($sort == 'material_description')
                                            @if ($direction == 'asc')
                                                <i class="fas fa-sort-up"></i>
                                            @else
                                                <i class="fas fa-sort-down"></i>
                                            @endif
                                        @else
                                            <i class="fas fa-sort"></i>
                                        @endif
                                    </div>
                                </th>
                                <th wire:click="order('project_code')" role="button">
                                    Proyecto
                                    <div class="float-right">
                                        @if ($sort == 'project_code')
                                            @if ($direction == 'asc')
                                                <i class="fas fa-sort-up"></i>
                                            @else
                                                <i class="fas fa-sort-down"></i>
                                            @endif
                                        @else
                                            <i class="fas fa-sort"></i>
                                        @endif
                                    </div>
                                </th>
                                <th wire:click="order('quantity_assigned_materials')" role="button">
                                    Cantidad<br>Comprometida
                                    <div class="float-right">
                                        @if ($sort == 'quantity_assigned_materials')
                                            @if ($direction == 'asc')
                                                <i class="fas fa-sort-up"></i>
                                            @else
                                                <i class="fas fa-sort-down"></i>
                                            @endif
                                        @else
                                            <i class="fas fa-sort"></i>
                                        @endif
                                    </div>
                                </th>
                                <th wire:click="order('quantity_picked_up_from_cre')" role="button">
                                    Retirado<br>de CRE
                                    <div class="float-right">
                                        @if ($sort == 'quantity_picked_up_from_cre')
                                            @if ($direction == 'asc')
                                                <i class="fas fa-sort-up"></i>
                                            @else
                                                <i class="fas fa-sort-down"></i>
                                            @endif
                                        @else
                                            <i class="fas fa-sort"></i>
                                        @endif
                                    </div>
                                </th>
                                <th wire:click="order('pending_material_in_cre')" role="button">
                                    Pendiente por<br>retirar de CRE
                                    <div class="float-right">
                                        @if ($sort == 'pending_material_in_cre')
                                            @if ($direction == 'asc')
                                                <i class="fas fa-sort-up"></i>
                                            @else
                                                <i class="fas fa-sort-down"></i>
                                            @endif
                                        @else
                                            <i class="fas fa-sort"></i>
                                        @endif
                                    </div>
                                </th>
                                <th wire:click="order('quantity_materials_delivered_to_builder')" role="button">
                                    Entregado<br>al constructor
                                    <div class="float-right">
                                        @if ($sort == 'quantity_materials_delivered_to_builder')
                                            @if ($direction == 'asc')
                                                <i class="fas fa-sort-up"></i>
                                            @else
                                                <i class="fas fa-sort-down"></i>
                                            @endif
                                        @else
                                            <i class="fas fa-sort"></i>
                                        @endif
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($materialSummaries as $materialSummary)
                                <tr>
                                    <td class="stacked-info text-right">
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
