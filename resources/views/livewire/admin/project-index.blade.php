<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card shadow-lg">
            <div class="card-header">
                @can('admin.projects.create')
                    <a href="{{route('admin.projects.create')}}" class="btn btn-xs btn-primary">Nuevo</a>    
                @endcan
                <div class="card-tools">
                    <div class="input-group input-group-sm" style="">
                        <input type="text" name="table_search" class="form-control float-right" wire:model.debounce.1500ms="search" placeholder="Buscar..">
                        {{-- @can('admin.projects.export')
                            <button class="btn btn-primary btn-xs" wire:click="export"><i class="far fa-file-excel"></i> Exportar</button>
                        @endcan --}}
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="overlay d-none" wire:loading.class.remove="d-none" wire:target="previousPage, nextPage, gotoPage, search">
                    <div class="spinner-grow" style="width: 3rem; height: 3rem;" role="status">
                        <span class="visually-hidden">Loading...</span>
                      </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover table-sm small mb-0">
                        <thead>
                            <tr class="text-center">
                                <th>C&oacute;digo</th>
                                <th>Ingreso<br>en sistema</th>
                                <th>Ingreso<br>en estado</th>
                                {{-- <th>Dias<br>estatico</th> --}}
                                
                                <th>Sistema</th>
                                <th>Distancia y<br>puntos</th>
                                <th>Fiscal<br>de CRE</th>
                                <th>Responsable<br>de estacado</th>
                                <th>Constructor</th>
                                <th>Ubicaci&oacute;n</th>
                                <th>Importe<br>Bs.</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($projects as $project)
                                <tr>
                                    <td class="stacked-info">
                                        {{ $project->code_pro }}
                                        <p class="mb-0 text-info small">{{ $project->status_name_pst }}</p>
                                    </td>
                                    <td class="stacked-info">
                                        {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $project->entry_date_pro)->format('d/m/Y') }}
                                        <p class="mb-0 text-info small">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $project->entry_date_pro)->diffForHumans() }}</p>
                                    </td>
                                    <td class="stacked-info">
                                        {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $project->status_log_manual_entry_date)->format('d/m/Y') }}
                                        <p class="mb-0 text-info small">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $project->status_log_manual_entry_date)->diffForHumans() }}</p>
                                        
                                    </td>
                                    {{-- <td class="text-end"> {{ $project->static_days }} </td> --}}
                                    
                                    <td> {{ $project->system_pro }} </td>
                                    <td class="text-end"> 
                                        @if ($project->distance_pro && $project->points_pro)
                                            {{$project->points_pro}}p/{{$project->distance_pro}}Km
                                        @else
                                            <span class="text-danger">Sin asignar</span>
                                        @endif    
                                    </td>
                                    <td> {{ ucwords(strtolower($project->cre_fiscal_pro)) }} </td>
                                    <td> {{ $project->stake_responsible }} </td>
                                    <td> {{ $project->assign_to_responsible }} </td>
                                    <td> {{ $project->address_pro }} </td>
                                    <td class="text-end"> {{ number_format($project->project_current_budget,2,'.',',')  }} </td>
                                    <td></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer clearfix">
                <div class="table-responsive">
                    {{ $projects->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
