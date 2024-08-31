<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow-lg">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12 mb-3">
                        <a class="btn btn-secondary d-print-none mx-1" href='{{route('admin.materials-summary.index')}}'>Cancelar</a>
                        <button class="btn btn-primary" wire:click="save">Guardar</button>
                    </div>
                </div>
                <div class="row invoice-info">
                    <div class="col-sm-4 invoice-col">
                        <address class="mb-1">
                            <strong>ID</strong><br>
                            {{$materialsSummary->id_msu}}
                        </address>
                        <address class="mb-1">
                            <strong>Fecha</strong><br>
                            <input class="form-control form-control-sm w-50" wire:model.live='manualEntryDate' type="text" placeholder="dd-mm-yyyy HH:MM:ss" autocapitalize='off' data-inputmask-alias="datetime" data-inputmask-inputformatt="dd-mm-yyyy HH:MM:ss" inputmode= "numeric">
                            @error('manualEntryDate')
                                <span class="text-info small"> {{$message}} </span>
                            @enderror
                        </address>
                        <address class="mb-1">
                            <strong>Nro. Correlativo</strong><br>
                            {{$materialsSummary->correlative_counter_msu??'--'}}
                        </address>
                        <address class="mb-1">
                            <strong>Tipo de resumen</strong><br>
                            {{$materialsSummary->summaryType->name_mqt}}
                            {{-- <div class="form-group">
                                <select class="form-control form-control-sm" wire:model.live="materialsSummaryTypeId" disabled wire:change='responsiblesVisibility'>
                                    @foreach ($materialSummaryTypes as $item)
                                        <option value="{{$item->id_mqt}}">{{$item->name_mqt}}</option>
                                    @endforeach
                                </select>
                            </div> --}}
                        </address>
                    </div>
                    <div class="col-sm-4 invoice-col">
                        @if ($materialsSummary->fiscal)
                            <address class="mb-1 {{$hideResponsibles}}">
                                <strong>Fiscal</strong><br>
                                <select class="form-control form-control-sm w-50" wire:model.live="fiscalId">
                                    <option value="">Seleccione un constructor</option>
                                    @foreach ($fiscals as $item)
                                        <option value="{{$item->id_usr}}">{{$item->full_name}}</option>
                                    @endforeach
                                </select>
                            </address>    
                        @endif
                        @if ($materialsSummary->builder)
                            <address class="mb-1 {{$hideResponsibles}}">
                                <strong>Constructor</strong><br>
                                <select class="form-control form-control-sm" wire:model.live="builderId">
                                    <option value="">Seleccione un constructor</option>
                                    @foreach ($builders as $item)
                                        <option value="{{$item->id_usr}}">{{$item->full_name}}</option>
                                    @endforeach
                                </select>
                            </address>    
                        @endif
                        <address class="mb-1">
                            <strong>Proyecto</strong><br>
                            {{$materialsSummary->project->code_pro}}
                        </address>
                        @if ($materialsSummary->reservation_number_msu)
                            <address class="mb-1">
                                <strong>Nro. de reserva</strong><br>
                                {{$materialsSummary->reservation_number_msu}}
                            </address>    
                        @endif
                    </div>
                    <div class="col-sm-4 invoice-col">
                        <div class="card">
                            <div class="card-header bg-info">
                                <h4 class="card-title">Materiales</h4>
                                <div class="card-tools">
                                    <div class="input-group input-group-sm">
                                        <input type="text" name="table_search" class="form-control float-right" placeholder="Buscar.." wire:model.live.debounce.1500ms='search'>
                                        @if ($materials->hasPages())
                                            <ul class="pagination pagination-sm m-0 float-right">
                                                @if ($materials->onFirstPage())
                                                    <li class="page-item disabled"><a class="page-link" href="#"><i class="fas fa-chevron-left"></i></a></li>
                                                @else
                                                    <li class="page-item"><a class="page-link" href="javascript:void(0)" wire:click="previousPage" wire:loading.attr="disabled"><i class="fas fa-chevron-left"></i></a></li>
                                                @endif
                        
                                                @if ($materials->hasMorePages())
                                                    <li class="page-item"><a class="page-link" href="javascript:void(0)" wire:click="nextPage" wire:loading.attr="disabled"><i class="fas fa-chevron-right"></i></a></li>
                                                @else
                                                    <li class="page-item disabled"><a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a></li>
                                                @endif
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                            </div>
                
                            <div class="card-body p-0">
                                <div class="overlay dark d-none" wire:loading.class="d-flex" wire:target="previousPage, nextPage, gotoPage, search, save, addToCurrentList, removeFromCurrentList">
                                    <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                                </div>
                                <table class="table table-sm table-striped table-hover text-sm">
                                    <tbody>
                                        @foreach ($materials as $material)
                                            <tr>
                                                <td class="pl-1"><span class="text-info">{{$material->code_mat}}</span> {{$material->description_mat}}</td>
                                                <td style="width: 50px" class="pr-1">
                                                    <button class="btn btn-sm btn-primary py-0" wire:click="addToCurrentList({{$material}})">Agregar</button>
                                                </td>
                                            </tr>    
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered table-hover table-striped table-sm mt-3">
                            <thead>
                                <tr>
                                    <th>COD</th>	
                                    <th>Descripci&oacute;n</th>
                                    <th>Comprometido<br>de la CRE</th>
                                    <th>Total retirado<br>de CRE</th>
                                    <th>Saldo por<br>retirar de CRE</th>
                                    <th>Entregado al<br>constructor<br>
                                        <em>(Prestamos incluidos)</em>
                                    </th>
                                    <th>
                                        Disponible en<br>el almac&eacute;n
                                    </th>
                                    <th width='100'>Movimiento</th>
                                    <th>Estado</th>
                                    <th>Quitar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @error('materialsToMove.*.quantity_prm')
                                    <span class="text-info small"> La columna "Movimiento" debe tener un dato numerico valido.</span>
                                @enderror
                                @foreach ($materialsToMove as $key => $materialToMove)
                                    <tr>
                                        <td>{{ $materialToMove['material']['code_mat'] }}</td>
                                        <td>{{ $materialToMove['material']['description_mat'] }}</td>
                                        <td class="text-end">
                                            @if (isset($laborDetailSummary[$materialToMove['material']['code_mat']]))
                                                {{ number_format($laborDetailSummary[$materialToMove['material']['code_mat']]['total_assigned'],2,'.',',') }}    
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            @if (isset($laborDetailSummary[$materialToMove['material']['code_mat']]))
                                                {{ number_format($laborDetailSummary[$materialToMove['material']['code_mat']]['materials_picked_up_from_cre'],2,'.',',') }}
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            @if (isset($laborDetailSummary[$materialToMove['material']['code_mat']]))
                                                {{ number_format($laborDetailSummary[$materialToMove['material']['code_mat']]['pending_material_in_cre'],2,'.',',') }}    
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            @if (isset($laborDetailSummary[$materialToMove['material']['code_mat']]))
                                                {{ number_format($laborDetailSummary[$materialToMove['material']['code_mat']]['total_materials_delivered_to_builder'],2,'.',',')}}
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            @if (isset($laborDetailSummary[$materialToMove['material']['code_mat']]))
                                                {{ number_format($laborDetailSummary[$materialToMove['material']['code_mat']]['quantity_in_warehouse'],2,'.',',')}}
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <input type="text" class="form-control form-control-sm text-end py-0 {{$errors->has('materialsToMove.'.$key.'.quantity_prm')?'is-invalid': ''}}" wire:model.live="materialsToMove.{{$key}}.quantity_prm" value="{{ $materialToMove['quantity_prm']??'0.00' }}">
                                        </td>
                                        <td class="text-center">
                                            <select class="" wire:model.live="materialsToMove.{{$key}}.status_id_prm">
                                                <option value="1">NVO</option>
                                                <option value="2">MEO</option>
                                                <option value="3">RBO</option>
                                                <option value="4">Indefinido</option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-xs btn-danger py-0" wire:click="removeFromMaterialsToMove({{$key}})"><i class="fas fa-fw fa-times"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section('js')
    <script>
        $('[data-inputmask-inputformat]').inputmask({
            onKeyDown: function (event, buffer, caretPos, opts) {
                console.log(event, buffer, caretPos, opts);

                // return processedValue;
            }
        });
        // $('[data-inputmask-inputformat]').on('keydown', function(){
        //     @this.set('manualEntryDate',$(this).val());
        // });
    </script>
@stop