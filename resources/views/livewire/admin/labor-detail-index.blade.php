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
                <div class="table-responsive">
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
                            @foreach ($laborDetails as $laborDetail)
                                <tr>
                                    <td>{{$laborDetail->id_lad}}</td>
                                    <td>{{$laborDetail->project->code_pro}}</td>
                                    <td>{{$laborDetail->graph_number_lad}}</td>
                                    <td>{{$laborDetail->level_of_tension_lad}}</td>
                                    <td>{{$laborDetail->destiny_lad}}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                            {{-- <span class="sr-only">Toggle Dropdown</span> --}}
                                            Dise&ntilde;o
                                            </button>
                                                <div class="dropdown-menu" role="menu" style="">
                                                    @can('admin.labor-details.show')
                                                        <a  wire:loading.class="disabled" class="dropdown-item" href='{{route('admin.labor-details.show', $laborDetail)}}'"><i class="fas fa-eye"></i> Ver</a>
                                                    @endcan
                                                    @can('admin.labor-details.internal-conciliation')
                                                        <a wire:loading.class="disabled" class="dropdown-item" href='{{route('admin.labor-details.internal-conciliation', $laborDetail)}}'"><i class="fas fa-clipboard-list"></i> Conciliacion interna</a>    
                                                    @endcan
                                                    @can('admin.labor-details.internal-conciliation-builder')
                                                        <a wire:loading.class="disabled" class="dropdown-item" href='{{route('admin.labor-details.internal-conciliation-builder', $laborDetail)}}'"><i class="fas fa-clipboard-list"></i> Conciliacion interna(Constructor)</a>    
                                                    @endcan
                                                    <a wire:loading.class="disabled" class="dropdown-item" href='{{route('admin.labor-details.internal-conciliation-cre-format', $laborDetail)}}'"><i class="fas fa-clipboard-list"></i> Conciliacion interna(Formato CRE)</a>    
                                                </div>
                                            </div>
                                            <div class="btn-group btn-group-sm">
                                                <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                                {{-- <span class="sr-only">Toggle Dropdown</span> --}}
                                                Construcci&oacute;n
                                                </button>
                                                    <div class="dropdown-menu" role="menu" style="">
                                                        @can('admin.labor-details.show')
                                                            <a  wire:loading.class="disabled" class="dropdown-item" href='{{route('admin.labor-details.show', $laborDetail)}}'"><i class="fas fa-eye"></i> Ver</a>
                                                        @endcan
                                                        @can('admin.labor-details.internal-conciliation')
                                                            <a wire:loading.class="disabled" class="dropdown-item" href='{{route('admin.labor-details.internal-conciliation', $laborDetail)}}'"><i class="fas fa-clipboard-list"></i> Conciliacion interna</a>    
                                                        @endcan
                                                        @can('admin.labor-details.internal-conciliation-builder')
                                                            <a wire:loading.class="disabled" class="dropdown-item" href='{{route('admin.labor-details.internal-conciliation-builder', $laborDetail)}}'"><i class="fas fa-clipboard-list"></i> Conciliacion interna(Constructor)</a>    
                                                        @endcan
                                                        <a wire:loading.class="disabled" class="dropdown-item" href='{{route('admin.labor-details.internal-conciliation-cre-format', $laborDetail)}}'"><i class="fas fa-clipboard-list"></i> Conciliacion interna(Formato CRE)</a>    
                                                    </div>
                                                </div>
                                    </td>
                                </tr>    
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
            </div>

            <div class="card-footer clearfix">
                <div class="table-responsive">
                    {{ $laborDetails->links() }}
                </div>
            </div>
        </div>
    </div>
</div>