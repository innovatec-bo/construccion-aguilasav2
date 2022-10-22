<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow-lg">
            
            <div class="card-header">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="groupByProject" wire:model="groupByProject">
                            <label class="form-check-label" for="groupByProject">Agrupar por proyecto <i  id="popover" class="fas fa-info-circle"></i></label>
                        </div>
                        <div class="form-group col-2">
                            <label for="exampleInputEmail1" class="mb-0">Proyecto</label>
                            <input type="text" class="form-control"  wire:model.debounce.1500ms="projectCode" id="exampleInputEmail1" placeholder="Codigo proyecto">
                            </div>
                    </div>
                </div>
                <div class="card-tools">
                    <div class="input-group input-group-sm" style="">
                        <input type="text" name="table_search" class="form-control float-right" wire:model.debounce.1500ms="search" placeholder="Buscar..">
                        {{-- @can('admin.projects.export')
                            <button class="btn btn-primary btn-xs" wire:click="export"><i class="far fa-file-excel"></i> Exportar</button>
                        @endcan --}}
                        
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="overlay dark d-none" wire:loading.class="d-flex"
                    wire:target="previousPage, nextPage, gotoPage, search,groupByProject">
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
                                        {{-- <p class="mb-0 text-warning">{{ $materialSummary->status_name_pst }}</p> --}}
                                    </td>
                                    <td>
                                        {{ $materialSummary->material_description }}
                                    </td>
                                    <td class="stacked-info">
                                        {{ $materialSummary->project_code }}
                                        {{-- <p class="mb-0 text-warning">{{ $materialSummary->status_name_pst }}</p> --}}
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
