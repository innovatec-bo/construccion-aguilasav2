<div class="row position-relative">
    <div class="overlay d-none" wire:loading.class.remove="d-none" wire:target="previousPage, nextPage, gotoPage, projectCode, workAreaSelected, statusSelected">
        <div class="spinner-grow" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
    </div>
    @can('admin.contracts.create')
        <div class="col-md-2">
            <div class="form-group">
                <label>&nbsp;</label>
                <a href="{{route('admin.contracts.create')}}" class="btn btn-primary btn-sm form-control" type="button">Nuevo contrato</a>
            </div>
        </div>
    @endcan
    <div class="col-md-12 mt-4">
        <div class="card shadow-lg">
            <div class="card-header d-none">
                @can('admin.contracts.create')
                    <a href="{{route('admin.contracts.create')}}" class="btn btn-xs btn-primary">Nuevo</a>    
                @endcan
                <div class="card-tools">
                    <div class="input-group input-group-sm" style="">
                        
                        @can('admin.users.export')
                            <button class="btn btn-primary btn-xs" wire:click="export"><i class="far fa-file-excel"></i> Exportar</button>
                        @endcan
                        
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover table-sm small mb-0">
                        <thead>
                            <tr>
                                <th>N&uacute;mero</th>
                                <th>Monto</th>
                                <th>Fecha de inicio</th>
                                <th>Fecha de fin</th>
                                <th class="text-center">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($contracts as $contract)
                                <tr>
                                    <td>
                                        {{$contract->contract_number_con}}
                                    </td>
                                    <td>
                                        {{number_format($contract->amount_con,2,'.',',')}}
                                    </td>
                                    <td class="stacked-info">
                                        {{ $contract->start_date_con->format('d/m/Y') }}
                                        <p class="mb-0 text-info small">{{ $contract->start_date_con->diffForHumans() }}</p>
                                    </td>
                                    <td class="stacked-info">
                                        {{$contract->expiration_date_con->format('d/m/Y')}}
                                        <p class="mb-0 text-info small">{{ $contract->expiration_date_con->diffForHumans() }}</p>
                                    </td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <a class="btn btn-transparent btn-sm" wire:loading.class="disabled" id="dropdownMenuLink" href="#" role="button" data-coreui-toggle="dropdown" aria-expanded="false">
                                                <x-coreui-icon svgClass="icon" icon="cil-options"/>
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="">
                                                @can('admin.contracts.edit')
                                                    <li><a wire:loading.class="disabled" class="dropdown-item" target="_blank" href='{{ route('admin.contracts.edit', $contract) }}'">Editar</a></li>
                                                @endcan
                                            </ul>
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
            {{ $contracts->links() }}
        </div>
    </div>
</div>
