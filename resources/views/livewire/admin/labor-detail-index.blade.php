<div class="row">
    <div class="col-md-2">
        <div class="form-group">
            <label>COD Proyecto</label>
            <input type="text" class="form-control form-control-sm" wire:model.debounce.1500ms="search">
            @error('projectCode')
                <span class="text-danger small">{{$message}}</span>
            @enderror
        </div>
    </div>
    <div class="col-md-12 mt-3">
        <div class="card shadow-lg">
            {{-- <div class="card-header">
                <div class="card-tools">
                    <div class="input-group input-group-sm" style="">
                        <input type="text" name="table_search" class="form-control float-right" wire:model.debounce.1500ms="search" placeholder="Buscar..">
                    </div>
                </div>
            </div> --}}
            <div class="card-body p-0">
                <div class="overlay dark d-none" wire:loading.class="d-flex" wire:target="previousPage, nextPage, gotoPage, search">
                    <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                </div>
                <div class="table-responsive overflow-visible">
                    <table class="table table-bordered table-hover table-striped table-sm mb-0">
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
                                        <p class="mb-0 text-info">{{ $project->status->status_name_pst }}</p>
                                    </td>
                                    <td>{{$project->laborDetailDesign->graph_number_lad}}</td>
                                    <td>{{$project->laborDetailDesign->level_of_tension_lad}}</td>
                                    <td>{{$project->laborDetailDesign->destiny_lad}}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                Dise&ntilde;o
                                            </button>
                                            <ul class="dropdown-menu">
                                                @can('admin.labor-details.show')
                                                    <li><a  wire:loading.class="disabled" class="dropdown-item" href='{{route('admin.labor-details.show', $project->laborDetailDesign)}}'">Ver</a></li>
                                                @endcan
                                                @can('admin.labor-details.internal-conciliation')
                                                    <li><a wire:loading.class="disabled" class="dropdown-item" href='{{route('admin.labor-details.internal-conciliation', $project->laborDetailDesign)}}'">Conciliacion interna</a></li>    
                                                @endcan
                                                @can('admin.labor-details.internal-conciliation-builder')
                                                    <li><a wire:loading.class="disabled" class="dropdown-item" href='{{route('admin.labor-details.internal-conciliation-builder', $project->laborDetailDesign)}}'">Conciliacion interna(Constructor)</a></li>    
                                                @endcan
                                                <li><a wire:loading.class="disabled" class="dropdown-item" href='{{route('admin.labor-details.internal-conciliation-cre-format', $project->laborDetailDesign)}}'">Conciliacion interna(Formato CRE)</a></li>    
                                            </ul>
                                        </div>
                                        @if ($project->laborDetailBuilding)
                                            <div class="btn-group">
                                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Construcci&oacute;n
                                                </button>
                                                <ul class="dropdown-menu">
                                                    @can('admin.labor-details.show')
                                                        <li><a  wire:loading.class="disabled" class="dropdown-item" href='{{route('admin.labor-details.show', $project->laborDetailBuilding)}}'">Ver</a></li>
                                                    @endcan
                                                    @can('admin.labor-details.internal-conciliation')
                                                        <li><a wire:loading.class="disabled" class="dropdown-item" href='{{route('admin.labor-details.internal-conciliation', $project->laborDetailBuilding)}}'">Conciliacion interna</a></li>
                                                    @endcan
                                                    @can('admin.labor-details.internal-conciliation-builder')
                                                        <li><a wire:loading.class="disabled" class="dropdown-item" href='{{route('admin.labor-details.internal-conciliation-builder', $project->laborDetailBuilding)}}'">Conciliacion interna(Constructor)</a></li>
                                                    @endcan
                                                    <li><a wire:loading.class="disabled" class="dropdown-item" href='{{route('admin.labor-details.internal-conciliation-cre-format', $project->laborDetailBuilding)}}'">Conciliacion interna(Formato CRE)</a></li>
                                                </ul>
                                            </div>
                                        @endif
                                    </td>
                                </tr>    
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 mt-3">
        <div class="table-responsive">
            {{ $projects->links() }}
        </div>
    </div>
</div>