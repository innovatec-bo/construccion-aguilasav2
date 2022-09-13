<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow-lg">
            <div class="card-header">
                <div class="col-md-4">
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
                
                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="table_search" class="form-control float-right" wire:model.debounce.1500ms="search" placeholder="Buscar..">
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="overlay dark d-none" wire:loading.class="d-flex"
                    wire:target="delete, previousPage, nextPage, gotoPage, search">
                    <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm table-hover table-striped">
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
                                    <td class="small stacked-info">
                                        {{ $materialSummary->entry_date_msu->format('d-m-Y H:i:s') }}
                                        <p class="mb-0 text-warning">{{ $materialSummary->entry_date_msu->diffForHumans() }}</p>
                                    </td>
                                    <td class="small stacked-info">
                                        <p class="mb-0">{{ $materialSummary->project->code_pro }}</p>
                                        <p class="mb-0 text-warning">{{ $materialSummary->project->status->status_name_pst }}</p>
                                    </td>
                                    <td class="small stacked-info">
                                        {{ $materialSummary->summaryType->name_mqt }} 
                                        <p class="mb-0 text-warning">{{ strtoupper($materialSummary->summaryType->movement_type_mqt) }}</p>
                                    </td>
                                    <td class="text-center">
                                        {{$materialSummary->projectMaterials->count()}}
                                    </td>
                                    <td class="text-center">
                                        @can('admin.materials-summary.edit')
                                            @if (in_array($materialSummary->summaryType->keyword_mqt, ['materials_picked_up_from_cre','materials_delivered_to_builder','materials_delivered_to_builder_loan','builder_returns_materials']))
                                                <a wire:loading.class="disabled" class="btn btn-primary btn-xs" href="{{ route('admin.materials-summary.edit', $materialSummary) }}"><i class="fas fa-pen"></i></a>
                                            @endif
                                        @endcan
                                        <a wire:loading.class="disabled" class="btn btn-secondary btn-xs" href='{{ route('admin.materials-summary.show', $materialSummary) }}'><i class="fas fa-eye"></i></a>
                                        @if (Auth::user()->email == 'jair@twiiti.com')
                                            <a href="javascript:void(0)" wire:loading.class="disabled" data-record="{{$materialSummary}}" class="btn btn-danger btn-xs lv-confirm-action"><i class="fas fa-trash"></i></a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer clearfix">
                <div class="table-responsive">
                    {{ $materialSummaryList->links() }}
                </div>
            </div>
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
