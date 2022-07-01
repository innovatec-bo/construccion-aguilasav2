<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow-lg">
            <div class="card-header">
                @can('admin.external-observations.create')
                    <a href="{{route('admin.external-observations.create')}}" class="btn btn-xs btn-primary">Nuevo</a>    
                @endcan
                <div class="card-tools">
                    <div class="input-group input-group-sm" style="">
                        <input type="text" name="table_search" class="form-control float-right" wire:model.debounce.1500ms="search" placeholder="Buscar..">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="overlay dark d-none" wire:loading.class="d-flex"
                    wire:target="previousPage, nextPage, gotoPage, search">
                    <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                </div>
                <table class="table table-bordered table-hover table-sm">
                    <thead>
                        <tr>
                            <th>Proyecto</th>
                            <th>Estado en<br>observaci&oacute;n</th>
                            <th>Observaci&oacute;n</th>
                            <th>Fecha<br>observaci&oacute;n</th>
                            <th>Fiscal<br>externo</th>
                            <th>Registrado por</th>
                            <th>Corregido por</th>
                            <th>Detalle de la correcci&oacute;n</th>
                            <th>Fecha de<br>correcci&oacute;n</th>
                            <th style="width: 130px">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($externalObservations as $externalObservation)
                            <tr>
                                <td>{{ $externalObservation->project->code_pro }}</td>
                                <td>{{ $externalObservation->status->status_name_pst }}</td>
                                <td class="text-sm"><i>{{$externalObservation->observation_efo}}</i></td>
                                <td>
                                    {{ $externalObservation->entry_date_efo->format('d-m-Y H:i:s')}}
                                    <small class="badge badge-primary">{{ $externalObservation->entry_date_efo->diffForHumans() }}</small>
                                </td>
                                <td>{{ $externalObservation->fiscal->full_name }}</td>
                                <td></td>
                                <td>
                                    @if ($externalObservation->fixedBy)
                                        {{ $externalObservation->fixedBy->full_name}}    
                                    @else
                                        <span class="text-danger">Sin corregir</span>    
                                    @endif
                                    
                                </td>
                                <td>{{ $externalObservation->fix_detail_efo }}</td>
                                <td>
                                    @if ($externalObservation->fixed_date_efo)
                                        {{ $externalObservation->fixed_date_efo->format('d-m-Y H:i:s')}}
                                        <small class="badge badge-primary">{{ $externalObservation->fixed_date_efo->diffForHumans() }}</small>    
                                    @else
                                        <span class="text-danger">Sin corregir</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-cogs"></i>
                                        </button>
                                        <div class="dropdown-menu" role="menu" style="">
                                            @can('admin.external-observations.edit')
                                                @if (!$externalObservation->fixed_efo)
                                                    {{-- <a  wire:loading.class="disabled" class="dropdown-item" href='{{route('admin.external-observations.edit', $externalObservation)}}'"><i class="fas fa-pen fa-fw"></i> Editar</a> --}}
                                                @endif
                                            @endcan
                                            @can('admin.external-observations.show')
                                                <a wire:loading.class="disabled" class="dropdown-item" href='{{route('admin.external-observations.show', $externalObservation)}}'"><i class="fas fa-eye fa-fw"></i> Ver</a>    
                                            @endcan
                                            @can('admin.external-observations.mark-as-fixed')
                                                @if (!$externalObservation->fixed_efo)
                                                    <a wire:loading.class="disabled" class="dropdown-item" href='{{route('admin.external-observations.mark-as-fixed', $externalObservation)}}'"><i class="fas fa-check fa-fw"></i> Marcar como corregido</a>
                                                @endif
                                            @endcan
                                            @can('admin.external-observations.destroy')
                                                @if (!$externalObservation->fixed_efo)
                                                    {{-- <a wire:loading.class="disabled" class="dropdown-item" href='{{route('admin.external-observations.destroy', $externalObservation)}}'"><i class="fas fa-trash-alt fa-fw"></i> Eliminar</a>     --}}
                                                @endif
                                            @endcan
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                {{ $externalObservations->links() }}
            </div>
        </div>
    </div>
</div>
