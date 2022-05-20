<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow-lg">
            <div class="card-header">
                <input class="form-control form-control-sm" type="text" wire:model.debounce.1500ms="search" placeholder="Buscar..">
            </div>
            <div class="card-body">
                <div class="overlay dark d-none" wire:loading.class="d-flex" wire:target="previousPage, nextPage, gotoPage, search">
                    <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 10px">ID</th>
                            <th>Fecha manual de ingreso</th>
                            <th>Tipo de movimiento</th>
                            <th>Nro.<br>Correlativo</th>
                            <th>Codigo</th>
                            <th>Descripcion</th>
                            <th>Cantidad</th>
                            <th>UM</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($materialSummaries as $materialSummary)
                            @foreach ($materialSummary->projectMaterials as $projectMaterial)
                                <tr>
                                    <td>{{$projectMaterial->material->id_mat}}</td>
                                    <td>{{$materialSummary->entry_date_msu}}</td>
                                    <td>{{ $materialSummary->summaryType->name_mqt }} <small
                                        class="badge badge-primary">{{ strtoupper($materialSummary->summaryType->movement_type_mqt) }}</small>
                                    </td>
                                    <td>{{$materialSummary->correlative_counter_msu}}</td>
                                    <td>{{$projectMaterial->material->code_mat}}</td>
                                    <td>{{$projectMaterial->material->description_mat}}</td>
                                    <td>{{ $projectMaterial->quantity_prm }}</td>
                                    <td>{{$projectMaterial->material->unit_of_measurement_mat}}</td>
                                    <td>
                                        @if ($projectMaterial->status)
                                            {{ $projectMaterial->status->detail_mst }}    
                                        @endif
                                    </td>
                                </tr>    
                            @endforeach    
                        @endforeach
                        
                    </tbody>
                </table>
            </div>

            {{-- <div class="card-footer clearfix">
                {{ $materials->links() }}
            </div> --}}
        </div>
    </div>
</div>