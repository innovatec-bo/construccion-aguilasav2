<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow-lg">
            <div class="card-header">
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
                    wire:target="previousPage, nextPage, gotoPage, search">
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
                                        {{ $materialSummary->material_id }}
                                        {{-- <p class="mb-0 text-warning">{{ $materialSummary->status_name_pst }}</p> --}}
                                    </td>
                                    <td>
                                        {{ $materialSummary->material_description }}
                                    </td>
                                    <td class="stacked-info">
                                        {{ $materialSummary->project_code }}
                                        {{-- <p class="mb-0 text-warning">{{ $materialSummary->status_name_pst }}</p> --}}
                                    </td>
                                    <td> 
                                        {{ $materialSummary->quantity_assigned_materials }} 
                                    </td>
                                    <td class="text-right"> 
                                            {{ $materialSummary->quantity_picked_up_from_cre }}
                                    </td>
                                    <td> 
                                        {{-- {{ $materialSummary->cre_fiscal_pro }}  --}}
                                    </td>
                                    <td> 
                                        {{-- {{ $materialSummary->stake_responsible }}  --}}
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
