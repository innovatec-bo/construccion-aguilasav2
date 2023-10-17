<div class="row position-relative">
    <div class="overlay d-none" wire:loading.class.remove="d-none" wire:target="previousPage, nextPage, gotoPage, projectCode, structureCode, triggerLoading">
        <div class="spinner-grow" role="status">
            <span class="visually-hidden">Cargando...</span>
          </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label>COD Proyecto</label>
            <input type="text" class="form-control form-control-sm" wire:model.debounce.1500ms="projectCode">
            @error('projectCode')
                <span class="text-danger small">{{$message}}</span>
            @enderror
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label>COD Estructura</label>
            <input type="text" class="form-control form-control-sm" wire:model.debounce.1500ms="structureCode">
            @error('structureCode')
                <span class="text-danger small">{{$message}}</span>
            @enderror
        </div>
    </div>
    <div class="col-md-2">
        <label>Desde</label>
        <div class="input-group input-group-sm date mb-3 from">
            <input class="form-control" type="text" value="{{$from}}" placeholder="dd-mm-yyyy">
            <span class="input-group-text input-group-append" role="button" id="basic-addon2"><i class="fa fa-calendar"></i></span>
            </div>
    </div>
    <div class="col-md-2">
        <label>Hasta</label>
        <div class="input-group input-group-sm date mb-3 to">
            <input class="form-control" type="text" value="{{$to}}" placeholder="dd-mm-yyyy">
            <span class="input-group-text input-group-append" role="button" id="basic-addon2"><i class="fa fa-calendar"></i></span>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label>&nbsp;</label>
            <button class="btn btn-primary btn-sm form-control" type="button">Decargar</button>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card shadow-lg">
            <div class="card-body p-0">
                
                <div class="table-responsive">
                    <table class="table table-bordered table-sm table-hover table-striped mb-0">
                        <thead>
                            <tr>
                                {{-- <th>ID</th> --}}
                                <th>Fecha de avance</th>
                                <th>Detalle</th>
                                <th>Fiscal</th>
                                <th>Proyecto</th>
                                <th>Direcci&oacute;n</th>
                                <th>Estructura</th>
                                <th class="stacked-info">Importe de<br>proyecto</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($workedUpStructures as $workedUpStructure)
                                <tr data-id="{{$workedUpStructure->id_wus}}">
                                    {{-- <td>{{$workedUpStructure->id_wus}}</td> --}}
                                    <td class="stacked-info">
                                        @if ($workedUpStructure->log)
                                            {{ $workedUpStructure->log->manual_entry_date_lal->format('d-m-Y H:i:s') }}
                                            <p class="mb-0 text-info">{{ $workedUpStructure->log->manual_entry_date_lal->diffForHumans() }}</p>        
                                        @endif
                                    </td>
                                    <td>
                                        @if ($workedUpStructure->log)
                                            {{$workedUpStructure->log->detail_lal}}    
                                        @endif
                                    </td>
                                    <td>
                                        @if ($workedUpStructure->log)
                                            {{ $workedUpStructure->log->user->full_name }}    
                                        @endif
                                    </td>
                                    <td class="stacked-info">
                                        {{ $workedUpStructure->laborCost->laborDetail->project->code_pro }}
                                        <p class="mb-0 text-info small">{{ $workedUpStructure->laborCost->laborDetail->project->status->status_name_pst }}</p>
                                    </td>
                                    @if ($workedUpStructure->laborCost->laborDetail->project->latitude_pro != '')
                                        <td class="stacked-info"> 
                                            {{ $workedUpStructure->laborCost->laborDetail->project->address_pro }} 
                                            <a class="small d-block" target="_blank" href="https://www.google.com/maps/search/?q={{$workedUpStructure->laborCost->laborDetail->project->latitude_pro}},{{$workedUpStructure->laborCost->laborDetail->project->longitude_pro}}" class="d-block">Ver en google maps</a>
                                        </td>
                                    @else
                                        <td> 
                                            {{ $workedUpStructure->laborCost->laborDetail->project->address_pro }} 
                                        </td>
                                    @endif
                                    <td class="stacked-info">
                                        {{$workedUpStructure->laborCost->buildingStructure->structure_code_bus}}<br>
                                        <p class="small my-0">
                                            {{$workedUpStructure->laborCost->activity_lac}} - 
                                            {{$workedUpStructure->laborCost->execution_lac}} -
                                            Bs.{{number_format($workedUpStructure->price_wus,2,'.',',')}} -
                                            {{number_format($workedUpStructure->worked_up_wus, 2,'.',',')}} {{$workedUpStructure->laborCost->buildingStructure->unit_of_measurement_bus}}
                                        </p>
                                    </td>
                                    <td class="text-center">
                                        {{number_format($workedUpStructure->laborCost->laborDetail->project->currentBudget,2,'.',',')}}
                                    </td>
                                </tr>    
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 mt-4">
        {{ $workedUpStructures->links() }}
    </div>
</div>
@push('scripts')
    <script>
        $(function() {
            $('.input-group.date').datepicker({
                language: "es",
                format: 'dd-mm-yyyy',
                autoclose: true,
                clearBtn: true,
            });
            $('.input-group.date').on('changeDate', function(e) {
                let date = null;
                if (e.date !== undefined) 
                {
                    date = moment(e.date).format('DD-MM-YYYY');
                }
                if ($(this).hasClass('from')) 
                {
                    @this.from = date;
                } 
                else 
                {
                    @this.to = date;
                }
                @this.triggerLoading();
            });
        });
    </script>
@endpush
