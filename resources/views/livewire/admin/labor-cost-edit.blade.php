<div class="row justify-content-center">
    <div class="col-md-4">
        <div class="card shadow-lg">
            <div class="card-header">
                <h3 class="card-title">Lista completa</h3>
                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="table_search" class="form-control float-right" placeholder="Buscar.." wire:model.live.debounce.1500ms='search'>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="overlay dark d-none" wire:loading.class="d-flex" wire:target="previousPage, nextPage, gotoPage, search, save, addToCurrentList, removeFromCurrentList">
                    <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                </div>
                <table class="table table-striped table-hover table-sm small mb-0">
                    <tbody>
                        @foreach ($materials as $material)
                            <tr>
                                <td><span class="text-warning">{{$material->code_mat}}</span> {{$material->description_mat}}</td>
                                <td style="width: 50px">
                                    <button class="btn btn-xs btn-primary waves-effect waves-light" wire:click="addToCurrentList({{$material}})"><i class="fas fa-angle-right"></i></button>
                                </td>
                            </tr>    
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer p-3">
                @if ($materials->hasPages())
                    <ul class="pagination pagination-sm m-0 float-right">
                        @if ($materials->onFirstPage())
                            <li class="page-item disabled"><a class="page-link" href="#"><i class="ti ti-chevrons-left ti-sm"></i></a></li>
                        @else
                            <li class="page-item"><a class="page-link" href="javascript:void(0)" wire:click="previousPage" wire:loading.attr="disabled"><i class="ti ti-chevrons-left ti-sm"></i></a></li>
                        @endif

                        @if ($materials->hasMorePages())
                            <li class="page-item last"><a class="page-link" href="javascript:void(0)" wire:click="nextPage" wire:loading.attr="disabled"><i class="ti ti-chevrons-right ti-sm"></i></a></li>
                        @else
                            <li class="page-item disabled"><a class="page-link" href="#"><i class="ti ti-chevrons-right ti-sm"></i></a></li>
                        @endif
                    </ul>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card card-widget widget-user-2 shadow-lg">
            <div class="card-header">
                <div class="widget-user-header">
                    <h3 class="widget-user-username ml-1">{{ $laborCost->buildingStructure->description_bus }}</h3>
                    <h5 class="widget-user-desc ml-1">{{ $laborCost->buildingStructure->structure_code_bus }}</h5>
                    <button type="button" class="btn btn-success float-end" wire:click="save">Guardar</button>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="overlay dark d-none" wire:loading.class="d-flex" wire:target="previousPage, nextPage, gotoPage, search, save, addToCurrentList, removeFromCurrentList">
                    <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                </div>
                <table class="table table-striped table-hover table-sm small mb-0">
                    <thead>
                        <tr>
                            <th style="width: 10px">Codigo</th>
                            <th>Material</th>
                            <th style="width: 150px">Cantidad</th>
                            <th style="width: 90px">Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($currentList as $custom)
                            <tr>
                                <td class="text-warning">{{ $custom['code_mat'] }}</td>
                                <td>{{ $custom['description_mat'] }}</td>
                                <td class="">
                                    <input type="text" class="input-mask text-right" name="" value="{{$custom['quantity_csm']}}" wire:model.live="currentList.{{$custom['id_mat']}}.quantity_csm" id="" style="width: 80px">
                                    {{ $custom['unit_of_measurement_mat'] }}
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-xs btn-danger waves-effect waves-light" wire:click="removeFromCurrentList({{$custom['id_mat']}})">
                                        <i class="fas fa-fw fa-times"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div