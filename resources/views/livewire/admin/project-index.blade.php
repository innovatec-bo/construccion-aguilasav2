<div class="row justify-content-center">
    <div class="col-md-10">
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
                                <th>Ingreso<br>en sistema</th>
                                <th>Estado</th>
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
                                    <td>{{ $project->code_pro }}</td>
                                    <td class="text-center" style="width: 100px">
                                        {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $project->entry_date_pro)->format('d/m/Y') }}
                                        <p class="small mb-0 text-warning">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $project->entry_date_pro)->diffForHumans() }}</p>
                                    </td>
                                    <td>
                                        {{ $project->status_name_pst }}
                                        <p class="small mb-0 text-warning">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $project->status_log_manual_entry_date)->diffForHumans() }}</p>
                                    </td>
                                    <td class="text-center" style="width: 100px">
                                        {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $project->status_log_manual_entry_date)->format('d/m/Y') }}
                                        
                                    </td>
                                    {{-- <td class="text-right"> {{ $project->static_days }} </td> --}}
                                    
                                    <td> {{ $project->system_pro }} </td>
                                    <td class="text-right"> 
                                        @if ($project->distance_pro && $project->points_pro)
                                            {{$project->points_pro}}p/{{$project->distance_pro}}Km
                                        @else
                                            <span class="text-danger">Sin asignar</span>
                                        @endif    
                                    </td>
                                    <td> {{ $project->cre_fiscal_pro }} </td>
                                    <td> {{ $project->stake_responsible }} </td>
                                    <td> {{ $project->assign_to_responsible }} </td>
                                    <td> {{ $project->address_pro }} </td>
                                    <td class="text-right"> {{ number_format($project->project_current_budget,2,'.',',')  }} </td>
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
