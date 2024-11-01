<div class="row position-relative">
    <div class="overlay d-none" wire:loading.class.remove="d-none" wire:target="previousPage, nextPage, gotoPage, projectCode, workAreaSelected, statusSelected">
        <div class="spinner-grow" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
    </div>
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">

        <div class="d-flex flex-column justify-content-center">
          <h4 class="mb-1">Proyectos</h4>
          <p class="mb-0">Listado de todos los proyectos del sistema</p>
        </div>
        <div class="d-flex align-content-center flex-wrap gap-4">
            <div class="d-flex gap-4">
                <button class="btn btn-sm btn-primary waves-effect" 
                wire:click="$dispatch('showModal', {data: {'alias' : 'admin.incident-create','size':'modal-sm','params' :{} }})"
                >Registrar incidencia</button>
                @can('admin.projects.create')
                    <a href="{{route('admin.projects.create')}}" class="btn btn-sm btn-primary waves-effect">Nuevo proyecto</a>    
                @endcan
            </div>
        </div>
    
      </div>
    <div class="col-md-2">
        <div class="form-group">
            <label>COD Proyecto</label>
            <input type="text" name="table_search" class="form-control form-control-sm" wire:model.live.debounce.1500ms="projectCode" placeholder="Buscar..">
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label>Area de trabajo</label>
            <select class="form-select form-select-sm" wire:model.live="workAreaSelected">
                <option value="">--Todos--</option>
                <option value="gir">GIR</option>
                <option value="gis">GIS</option>
            </select>    
        </div>
    </div>
    {{-- <div class="col-md-2">
        <div class="form-group">
            <label>Fiscal</label>
            <select class="form-control" wire:model.live="fiscalSelected">
                <option value="">--Todos--</option>
                @foreach ($fiscalList as $user)
                    <option value="{{$user->id_usr}}">{{$user->fullName}}</option>
                @endforeach
            </select>    
        </div>
    </div> --}}
    <div class="col-md-2">
        <div class="form-group">
            <label>Estado</label>
            <select class="form-select form-select-sm" wire:model.live="statusSelected">
                <option value="">--Todos--</option>
                @foreach ($statusList as $status)
                    <option value="{{$status->id_pst}}">{{$status->status_name_pst}}</option>
                @endforeach
            </select>    
        </div>
    </div>
    <div class="col-md-12 mt-4">
        <div class="card shadow-lg">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover table-sm small mb-0">
                        <thead>
                            <tr>
                                <th>C&oacute;digo</th>
                                <th>Ingreso<br>en sistema</th>
                                <th>Ingreso<br>en estado</th>
                                <th>Sistema</th>
                                <th>Distancia<br>y puntos</th>
                                <th>Fiscal<br>de CRE</th>
                                <th>Direcci&oacute;n</th>
                                <th>Importe</th>
                                <th class="text-center"><i class="ti ti-dots-vertical"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($projects as $project)
                                <tr>
                                    <td class="stacked-info">
                                        {{ $project->code_pro }}
                                        <p class="mb-0 text-info small">{{ $project->status->status_name_pst }}</p>    
                                    </td>
                                    <td class="stacked-info">
                                        {{ $project->entry_date_pro->format('d/m/Y') }}
                                        <p class="mb-0 text-info small">{{ $project->entry_date_pro->diffForHumans() }}</p>
                                    </td>
                                    <td class="stacked-info">
                                        {{$project->currentStatusLog->manual_entry_date_psl->format('d/m/Y')}}
                                        <p class="mb-0 text-info small">{{ $project->currentStatusLog->manual_entry_date_psl->diffForHumans() }}</p>
                                    </td>
                                    <td>
                                        {{$project->system->name}}
                                    </td>
                                    <td>{{$project->points_pro}}p/{{$project->distance_pro}}Km</td>
                                    <td>
                                        @if ($project->creFiscal)
                                            {{$project->creFiscal->fullName}}    
                                        @endif
                                    </td>
                                    @if ($project->latitude_pro != '')
                                        <td class="stacked-info"> 
                                            {{ $project->address_pro }} 
                                            <a class="small d-block" target="_blank" href="https://www.google.com/maps/search/?q={{$project->latitude_pro}},{{$project->longitude_pro}}" class="d-block">Ver en google maps</a>
                                        </td>
                                    @else
                                        <td> 
                                            {{ $project->address_pro }} 
                                        </td>
                                    @endif
                                    <td class="text-end fw-bold">{{number_format($project->currentBudget, 2,'.',',')}}/{{$project->productionPercentage}}</td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false" wire:loading.class="disabled"><i class="ti ti-dots-vertical"></i></button>
                                            <div class="dropdown-menu" style="">
                                                @can('admin.projects.edit')
                                                    <a class="dropdown-item waves-effect" target="_blank" wire:loading.class="disabled" href='{{ route('admin.projects.edit', $project) }}'">Editar</a>
                                                @endcan
                                                @can('admin.projects.status-management')
                                                    <a class="dropdown-item waves-effect" wire:loading.class="disabled" target="_blank" href="{{route('admin.projects.status-management', $project->id_pro)}}">Administraci&oacute;n de estados</a>
                                                @endcan
                                                @if (Auth::user()->hasRole('Responsable de Almac') && !$project->project_has_returned_materials_to_cre && $project->status_pro == 34 && $enableManualApprovementForConciliations)
                                                    <a class="dropdown-item waves-effect" wire:loading.class="disabled" href="javascript:void(0);"  wire:click="$dispatch('showModal','admin.conciliation-manual-approvement', {{$project->id_pro}})">Aprobar conciliaci&oacute;n</a>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- <div class="card-footer clearfix">
                
            </div> --}}
        </div>
    </div>
    <div class="col-md-12 mt-4">
        <div class="table-responsive">
            {{ $projects->links(data: ['scrollTo' => false]) }}
        </div>
    </div>
</div>
