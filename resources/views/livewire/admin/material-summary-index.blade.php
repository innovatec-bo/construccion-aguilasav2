<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow-lg">
            <div class="card-header">
                <input class="form-control form-control-sm" type="text" wire:model.debounce.2s="search" placeholder="Buscar..">
            </div>

            <div class="card-body">
                <div class="overlay dark d-none" wire:loading.class="d-flex" wire:target="delete, previousPage, nextPage, gotoPage, search">
                    <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 10px">ID</th>
                            <th>Fiscal</th>
                            <th>Constructor</th>
                            <th>Fecha de<br>entrada manual</th>
                            <th>Proyecto</th>
                            <th>Tipo de movimiento</th>
                            <th style="width: 130px">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($materialSummaryList as $materialSummary)
                            <tr>
                                <td>{{$materialSummary->id_msu}}</td>
                                <td>
                                    @if ($materialSummary->fiscal)
                                        {{$materialSummary->fiscal->full_name}}    
                                    @endif
                                    
                                </td>
                                <td>
                                    @if ($materialSummary->builder)
                                        {{$materialSummary->builder->full_name}}    
                                    @endif
                                </td>
                                <td>{{$materialSummary->entry_date_msu->format('d-m-Y H:i:s')}}
                                    <small class="badge badge-primary">{{$materialSummary->entry_date_msu->diffForHumans()}}</small>
                                </td>
                                <td>{{$materialSummary->project->code_pro}}</td>
                                <td>{{$materialSummary->summaryType->name_mqt}} <small class="badge badge-primary">{{strtoupper($materialSummary->summaryType->movement_type_mqt)}}</small></td>
                                <td>
                                    <button type="button" wire:loading.class="disabled" class="btn btn-secondary btn-sm" onclick="window.location.href='{{route('admin.materials-summary.show', $materialSummary)}}'"><i class="fas fa-eye"></i></button>
                                    <a href="javascript:void(0)" wire:loading.class="disabled" data-record='{{$materialSummary}}' class="btn btn-danger btn-sm lv-confirm-action"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>    
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                {{ $materialSummaryList->links() }}
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        $(function () {
            $(document).on('click', '.lv-confirm-action', function () {
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
            }).then(function (result) {
                if (result.value === true) {
                @this.delete(recordId);
                }
            });
        }
    </script>
@endpush