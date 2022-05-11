<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow-lg">
            <div class="card-header">
                <div class="form-group">
                    {!! Form::label('builders', 'Constructor') !!}
                    {!! Form::select('builders', $builders, null, ['id' => 'builders', 'class' => 'form-control', 'required' => 'required', 'wire:model' => 'builderSelected']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('statusSelected', 'Estado del proyecto') !!}
                    {!! Form::select('statusSelected', $statusToVerify, null, ['id' => 'statusSelected', 'class' => 'form-control', 'wire:model' => 'statusSelected']) !!}
                </div>
                <input class="form-control form-control-sm" type="text" wire:model.debounce.1500ms="search" placeholder="Buscar..">
            </div>
            <div class="card-body">
                <div class="overlay dark d-none" wire:loading.class="d-flex" wire:target="previousPage, nextPage, gotoPage, search, builderSelected, statusSelected">
                    <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 10px">ID</th>
                            <th>Proyecto</th>
                            <th>Estado</th>
                            <th>Constructor</th>
                            <th style="width: 130px">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($projects as $project)
                            <tr>
                                <td>{{$project->id_pro}}</td>
                                <td>{{$project->code_pro}}</td>
                                <td>{{$project->status->status_name_pst}}</td>
                                <td>
                                    @foreach ($project->statusLogResponsibles as $statusLogResponsible)
                                        @if ($statusLogResponsible->responsible->user->hasRole('Builder'))
                                            {{$statusLogResponsible->responsible->user->full_name}}
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    <a wire:loading.class="disabled" class="btn btn-info btn-sm" href='{{route('admin.labor-details.internal-conciliation', $project->laborDetail)}}'" data-toggle="tooltip" data-placement="top" title="Conciliacion interna"><i class="fas fa-clipboard-list"></i></a>
                                    <a wire:loading.class="disabled" class="btn btn-warning btn-sm" href='{{route('admin.labor-details.internal-conciliation-builder', $project->laborDetail)}}'" data-toggle="tooltip" data-placement="top" title="Conciliacion interna(Constructor)"><i class="fas fa-clipboard-list"></i></a>
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