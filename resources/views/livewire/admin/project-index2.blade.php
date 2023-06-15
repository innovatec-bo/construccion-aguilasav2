<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card shadow-lg">
            <div class="card-header">
                @can('admin.projects.create')
                    <a href="{{route('admin.projects.create')}}" class="btn btn-xs btn-primary">Nuevo</a>    
                @endcan
                <div class="card-tools">
                    <div class="input-group input-group-sm" style="">
                        <input type="text" name="table_search" class="form-control float-right" wire:model.debounce.1500ms="projectCode" placeholder="Buscar..">
                        @can('admin.users.export')
                            <button class="btn btn-primary btn-xs" wire:click="export"><i class="far fa-file-excel"></i> Exportar</button>
                        @endcan
                        
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="overlay d-none" wire:loading.class.remove="d-none" wire:target="previousPage, nextPage, gotoPage, projectCode">
                    <div class="spinner-grow" role="status">
                        <span class="visually-hidden">Loading...</span>
                      </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover table-sm small mb-0">
                        <thead>
                            <tr>
                                <th style="width: 10px">C&oacute;digo</th>
                                <th>Ingreso<br>en sistema</th>
                                <th>Ingreso<br>en estado</th>
                                <th>Sistema</th>
                                <th>Distancia<br>y puntos</th>
                                <th>Fiscal<br>de CRE</th>
                                <th>Direcci&oacute;n</th>
                                <th>Importe</th>
                                <th style="width: 130px">Opciones</th>
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
                                    <td>{{$project->system->name}}</td>
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
                                    <td class="text-end">{{number_format($project->currentBudget, 2,'.',',')}}</td>
                                    <td class="text-center">
                                        @can('admin.projects.edit')
                                            <a wire:loading.class="disabled" class="btn btn-primary btn-sm" href='{{ route('admin.projects.edit', $project) }}'"><i class="fas fa-pen"></i></a>    
                                        @endcan
                                        @can('admin.projects.show')
                                            <a wire:loading.class="disabled" class="btn btn-secondary btn-sm" href='{{ route('admin.projects.show', $project) }}'"><i class="fas fa-eye"></i></a>    
                                        @endcan
                                        @can('admin.projects.destroy')
                                            <form method="post" action="{{ route('admin.projects.destroy', $project) }}"
                                                class="d-inline">
                                                @method('delete')
                                                @csrf
                                                <button wire:loading.class="disabled" type="submit" onclick="return confirm('Eliminar?')" class="btn btn-danger btn-sm"><i
                                                        class="fas fa-trash-alt"></i></button>
                                            </form>    
                                        @endcan
                                    </td>
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
