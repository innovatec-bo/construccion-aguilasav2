<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card shadow-lg">
            <div class="card-header">
                <input class="form-control form-control-sm" type="text" wire:model.debounce.1500ms="search" placeholder="Buscar por codigo de material..">
            </div>
            <div class="card-body">
                <div class="overlay dark d-none" wire:loading.class="d-flex" wire:target="previousPage, nextPage, gotoPage, search">
                    <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                </div>
                {{$search}}
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 10px">ID<br>Movimiento</th>
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
                                @if (isset($search) && $search != "")
                                    @if ($search == $projectMaterial->material->code_mat)
                                        <tr>
                                            <td>{{$materialSummary->id_msu}}</td>
                                            <td>
                                                {{$materialSummary->entry_date_msu->format('d/m/Y H:i:s')}}<br>
                                                {{$materialSummary->entry_date_msu->diffForHumans()}}
                                            </td>
                                            <td>{{ $materialSummary->summaryType->name_mqt }} 
                                                @if (strtoupper($materialSummary->summaryType->movement_type_mqt) == 'OUT')
                                                    <small class="badge badge-warning">{{ strtoupper($materialSummary->summaryType->movement_type_mqt) }}</small>    
                                                @elseif(strtoupper($materialSummary->summaryType->movement_type_mqt) == 'IN')
                                                    <small class="badge badge-success">{{ strtoupper($materialSummary->summaryType->movement_type_mqt) }}</small>
                                                @else
                                                    <small class="badge badge-primary">{{ strtoupper($materialSummary->summaryType->movement_type_mqt) }}</small>
                                                @endif
                                            </td>
                                            <td>{{$materialSummary->correlative_counter_msu}}</td>
                                            <td class="text-center">{{$projectMaterial->material->code_mat}}</td>
                                            <td>{{$projectMaterial->material->description_mat}}</td>
                                            <td class="text-end">{{ $projectMaterial->quantity_prm }}</td>
                                            <td>{{$projectMaterial->material->unit_of_measurement_mat}}</td>
                                            <td>
                                                @if ($projectMaterial->status)
                                                    {{ $projectMaterial->status->detail_mst }}    
                                                @endif
                                            </td>
                                        </tr>    
                                    @endif
                                @else
                                    <tr>
                                        <td>{{$materialSummary->id_msu}}</td>
                                        <td>
                                            {{$materialSummary->entry_date_msu->format('d/m/Y H:i:s')}}<br>
                                            <span class="text-info">{{$materialSummary->entry_date_msu->diffForHumans()}}</span>
                                        </td>
                                        <td>{{ $materialSummary->summaryType->name_mqt }}
                                            @if (strtoupper($materialSummary->summaryType->movement_type_mqt) == 'OUT')
                                                <small class="badge badge-warning">{{ strtoupper($materialSummary->summaryType->movement_type_mqt) }}</small>    
                                            @elseif(strtoupper($materialSummary->summaryType->movement_type_mqt) == 'IN')
                                                <small class="badge badge-success">{{ strtoupper($materialSummary->summaryType->movement_type_mqt) }}</small>
                                            @else
                                                <small class="badge badge-primary">{{ strtoupper($materialSummary->summaryType->movement_type_mqt) }}</small>
                                            @endif
                                        </td>
                                        <td>{{$materialSummary->correlative_counter_msu}}</td>
                                        <td class="text-center">{{$projectMaterial->material->code_mat}}</td>
                                        <td>{{$projectMaterial->material->description_mat}}</td>
                                        <td class="text-end">{{ $projectMaterial->quantity_prm }}</td>
                                        <td>{{$projectMaterial->material->unit_of_measurement_mat}}</td>
                                        <td>
                                            @if ($projectMaterial->status)
                                                {{ $projectMaterial->status->detail_mst }}    
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                                    
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