<div class="row position-relative">
    <div class="overlay d-none" wire:loading.class.remove="d-none" wire:target="delete, previousPage, nextPage, gotoPage, idMSU, projectCode, materialSummaryTypeSelected, from, to">
        <div class="spinner-grow" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label>ID de movimiento</label>
            <input type="text" class="form-control form-control-sm" wire:model.debounce.1500ms="idMSU">
            @error('idMSU')
                <span class="text-danger small">{{$message}}</span>
            @enderror
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
    <div class="col-md-3">
        <div class="form-group">
            <label>Tipo de movimiento</label>
            <select class="form-control form-control-sm" wire:model="materialSummaryTypeSelected">
                <option value=""></option>
                @foreach ($materialSummaryTypes as $materialSummaryType)
                    <option value="{{$materialSummaryType->id_mqt}}">{{$materialSummaryType->name_mqt}}</option>
                @endforeach
            </select>
            
        </div>
    </div>
    <div class="col-md-2">
        <label>Desde</label>
        <div class="input-group input-group-sm date mb-3 from">
            <input class="form-control" type="text" value="{{$from}}" placeholder="dd/mm/yyyy">
            <span class="input-group-text input-group-append" id="basic-addon2"><i class="fa fa-calendar"></i></span>
          </div>
    </div>
    <div class="col-md-2">
        <label>Hasta</label>
        <div class="input-group input-group-sm date mb-3 to">
            <input class="form-control" type="text" value="{{$to}}" placeholder="dd/mm/yyyy">
            <span class="input-group-text input-group-append" id="basic-addon2"><i class="fa fa-calendar"></i></span>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card shadow-lg">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm table-hover table-striped mb-0">
                        <thead>
                            <tr>
                                <th style="width: 10px">ID</th>
                                <th>Fiscal</th>
                                <th>Constructor</th>
                                <th>Fecha de<br>entrada manual</th>
                                <th>Proyecto</th>
                                <th>Tipo de movimiento</th>
                                <th>Items</th>
                                <th style="width: 130px">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($materialSummaryList as $materialSummary)
                                <tr>
                                    <td>{{ $materialSummary->id_msu }}</td>
                                    <td>
                                        @if ($materialSummary->fiscal)
                                            {{ $materialSummary->fiscal->full_name }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($materialSummary->builder)
                                            {{ $materialSummary->builder->full_name }}
                                        @endif
                                    </td>
                                    <td class="stacked-info">
                                        {{ $materialSummary->entry_date_msu->format('d-m-Y H:i:s') }}
                                        <p class="mb-0 text-info">{{ $materialSummary->entry_date_msu->diffForHumans() }}</p>
                                    </td>
                                    <td class="stacked-info">
                                        <p class="mb-0">{{ $materialSummary->project->code_pro }}</p>
                                        <p class="mb-0 text-info">{{ $materialSummary->project->status->status_name_pst }}</p>
                                    </td>
                                    <td class="stacked-info">
                                        {{ $materialSummary->summaryType->name_mqt }} 
                                        <p class="mb-0 text-info">{{ strtoupper($materialSummary->summaryType->movement_type_mqt) }}</p>
                                    </td>
                                    <td class="text-center">
                                        {{$materialSummary->projectMaterials->count()}}
                                    </td>
                                    <td class="text-center">
                                        
                                        
                                        <div class="dropdown">
                                            
                                            <a class="btn btn-transparent btn-sm" wire:loading.class="disabled" id="dropdownMenuLink" href="#" role="button" data-coreui-toggle="dropdown" aria-expanded="false">
                                                <x-coreui-icon svgClass="icon" icon="cil-options"/>
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="">
                                                <li><a wire:loading.class="disabled" class="dropdown-item" target="_blank" href='{{ route('admin.materials-summary.show', $materialSummary) }}'">Ver</a></li>
                                                @can('admin.materials-summary.edit')
                                                    @if (in_array($materialSummary->summaryType->keyword_mqt, ['materials_picked_up_from_cre','materials_delivered_to_builder','materials_delivered_to_builder_loan','builder_returns_materials']))
                                                        <li><a wire:loading.class="disabled" class="dropdown-item" target="_blank" href="{{ route('admin.materials-summary.edit', $materialSummary) }}">Editar</a></li>
                                                    @endif
                                                @endcan
                                                @if (Auth::user()->email == 'jair@twiiti.com')
                                                    <li><a href="javascript:void(0)" wire:loading.class="disabled" class="dropdown-item lv-confirm-action" data-record="{{$materialSummary}}">Eliminar</a></li>
                                                @endif
                                            </ul>
                                        </div>
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
        <div class="table-responsive">
            {{ $materialSummaryList->links() }}
        </div>
    </div>
</div>
@push('scripts')
    <script>
        $(function() {
            $(document).on('click', '.lv-confirm-action', function() {
                var record = $(this).data('record');
                var question = $(this).data('confirm-question');
                confirmSubmit(question, record);
            });

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
                    Livewire.emit('fromChanged', date); 
                    console.log(date);  
                } 
                else 
                {
                    Livewire.emit('toChanged', date);
                }
            });
        });

        function confirmSubmit(question, recordId) {
            Swal.fire({
                title: "Eliminar registro?",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Si!",
                cancelButtonText: "No"
            }).then(function(result) {
                if (result.value === true) {
                    @this.delete(recordId);
                }
            });
        }

        
    </script>
@endpush
