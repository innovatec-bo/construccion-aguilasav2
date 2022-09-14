<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow-lg">
            <div class="card-header">
                <div class="card-tools">
                    <div class="input-group input-group-sm" style="">
                        <input type="text" name="table_search" class="form-control float-right" wire:model.debounce.1500ms="search" placeholder="Buscar..">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="overlay dark d-none" wire:loading.class="d-flex" wire:target="previousPage, nextPage, gotoPage, search">
                    <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                </div>
                <div class="table-responsive overflow-visible">
                    <table class="table table-bordered table-hover table-striped table-sm">
                        <thead>
                            <tr>
                                <th style="width: 10px">ID</th>
                                <th>Proyecto</th>
                                <th>Nro. Grafo</th>
                                <th>Nivel de tension</th>
                                <th>Destino</th>
                                <th style="width: 190px">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($projects as $project)
                                <tr>
                                    <td>{{$project->laborDetailDesign->id_lad}}</td>
                                    {{-- <td>
                                        {{$project->code_pro}}
                                    </td> --}}
                                    <td class="stacked-info">
                                        <p class="mb-0">{{ $project->code_pro }}</p>
                                        <p class="mb-0 text-warning">{{ $project->status->status_name_pst }}</p>
                                    </td>
                                    <td>{{$project->laborDetailDesign->graph_number_lad}}</td>
                                    <td>{{$project->laborDetailDesign->level_of_tension_lad}}</td>
                                    <td>{{$project->laborDetailDesign->destiny_lad}}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                            {{-- <span class="sr-only">Toggle Dropdown</span> --}}
                                            Dise&ntilde;o
                                            </button>
                                            <div class="dropdown-menu" role="menu" style="">
                                                @can('admin.labor-details.show')
                                                    <a  wire:loading.class="disabled" class="dropdown-item" href='{{route('admin.labor-details.show', $project->laborDetailDesign)}}'"><i class="fas fa-eye"></i> Ver</a>
                                                @endcan
                                                @can('admin.labor-details.internal-conciliation')
                                                    <a wire:loading.class="disabled" class="dropdown-item" href='{{route('admin.labor-details.internal-conciliation', $project->laborDetailDesign)}}'"><i class="fas fa-clipboard-list"></i> Conciliacion interna</a>    
                                                @endcan
                                                @can('admin.labor-details.internal-conciliation-builder')
                                                    <a wire:loading.class="disabled" class="dropdown-item" href='{{route('admin.labor-details.internal-conciliation-builder', $project->laborDetailDesign)}}'"><i class="fas fa-clipboard-list"></i> Conciliacion interna(Constructor)</a>    
                                                @endcan
                                                <a wire:loading.class="disabled" class="dropdown-item" href='{{route('admin.labor-details.internal-conciliation-cre-format', $project->laborDetailDesign)}}'"><i class="fas fa-clipboard-list"></i> Conciliacion interna(Formato CRE)</a>    
                                            </div>
                                        </div>
                                        @if ($project->laborDetailBuilding)
                                            <div class="btn-group btn-group-sm">
                                                <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                                {{-- <span class="sr-only">Toggle Dropdown</span> --}}
                                                Construcci&oacute;n
                                                </button>
                                                <div class="dropdown-menu" role="menu" style="">
                                                    @can('admin.labor-details.show')
                                                        <a  wire:loading.class="disabled" class="dropdown-item" href='{{route('admin.labor-details.show', $project->laborDetailBuilding)}}'"><i class="fas fa-eye"></i> Ver</a>
                                                    @endcan
                                                    @can('admin.labor-details.internal-conciliation')
                                                        <a wire:loading.class="disabled" class="dropdown-item" href='{{route('admin.labor-details.internal-conciliation', $project->laborDetailBuilding)}}'"><i class="fas fa-clipboard-list"></i> Conciliacion interna</a>    
                                                    @endcan
                                                    @can('admin.labor-details.internal-conciliation-builder')
                                                        <a wire:loading.class="disabled" class="dropdown-item" href='{{route('admin.labor-details.internal-conciliation-builder', $project->laborDetailBuilding)}}'"><i class="fas fa-clipboard-list"></i> Conciliacion interna(Constructor)</a>    
                                                    @endcan
                                                    <a wire:loading.class="disabled" class="dropdown-item" href='{{route('admin.labor-details.internal-conciliation-cre-format', $project->laborDetailBuilding)}}'"><i class="fas fa-clipboard-list"></i> Conciliacion interna(Formato CRE)</a>    
                                                </div>
                                            </div>    
                                        @endif
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