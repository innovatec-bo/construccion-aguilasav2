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
                <table class="table table-bordered table-sm table-hover table-striped">
                    <thead>
                        <tr>
                            <th style="width: 10px">ID</th>
                            <th>Proyecto</th>
                            <th>Fiscal</th>
                            <th>Constructor</th>
                            <th>Movimientos</th>
                            <th style="width: 130px">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($projects as $project)
                            <tr>
                                <td>{{$project->id_pro}}</td>
                                <td class="stacked-info">
                                    {{$project->code_pro}}
                                    <p class="mb-0 text-warning">{{$project->status->status_name_pst}}</p>
                                </td>
                                <td>
                                    @foreach ($project->statusLogResponsibles as $statusLogResponsible)
                                        @if ($statusLogResponsible->responsible->user->hasRole('Fiscal'))
                                            {{$statusLogResponsible->responsible->user->full_name}}
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($project->statusLogResponsibles as $statusLogResponsible)
                                        @if ($statusLogResponsible->responsible->user->hasRole('Builder'))
                                            {{$statusLogResponsible->responsible->user->full_name}}
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    {{$project->materialSummaries->count()}}
                                </td>
                                <td class="text-center">
                                    <a  wire:loading.class="disabled" class="btn btn-primary btn-sm" href='{{route('admin.materials-summary.grouped-movement-details', $project)}}'"><i class="fas fa-eye"></i></a>
                                </td>
                            </tr>    
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                {{ $projects->links() }}
            </div>
        </div>
    </div>
</div>