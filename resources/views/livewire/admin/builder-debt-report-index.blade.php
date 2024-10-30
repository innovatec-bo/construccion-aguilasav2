<div class="row position-relative">
    <div class="overlay d-none" wire:loading.class.remove="d-none" wire:target="previousPage, nextPage, gotoPage, builderSelected, statusSelected, search">
        <div class="spinner-grow" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label for="builders" class="form-label">Constructor</label>
            <select id="builders" name="builders" class="form-select form-select-sm" required wire:model.live="builderSelected">
                @foreach ($builders as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label for="statusSelected" class="form-label">Estado del proyecto</label>
            <select id="statusSelected" name="statusSelected" class="form-select form-select-sm" wire:model.live="statusSelected">
                @foreach ($statusToVerify as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-2">
        <label class="form-label">&nbsp;</label>
        <input class="form-control form-control-sm" type="text" wire:model.live.debounce.1500ms="search" placeholder="Buscar..">
    </div>
    <div class="col-md-12 mt-4">
        <div class="card shadow-lg">
            <div class="card-body p-0">
                <div class="overlay dark d-none" wire:loading.class="d-flex" wire:target="previousPage, nextPage, gotoPage, search, builderSelected, statusSelected">
                    <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover table-sm small mb-0">
                        <thead>
                            <tr>
                                <th style="width: 10px">ID</th>
                                <th>Proyecto</th>
                                <th>Constructor</th>
                                <th style="width: 130px">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($projects as $project)
                                <tr>
                                    <td>{{$project->id_pro}}</td>
                                    <td class="stacked-info">
                                        {{$project->code_pro}}
                                        <p class="mb-0 text-info">{{$project->status->status_name_pst}}</p>
                                    </td>
                                    <td>
                                        @foreach ($project->statusLogResponsibles as $statusLogResponsible)
                                            @if ($statusLogResponsible->responsible->user->hasRole('Builder'))
                                                {{$statusLogResponsible->responsible->user->full_name}}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td class="text-center">
                                        <a wire:loading.class="disabled" class="btn btn-info btn-sm" href='{{route('admin.labor-details.internal-conciliation', $project->laborDetailDesign)}}'" data-toggle="tooltip" data-placement="top" title="Conciliacion interna"><i class="fas fa-clipboard-list"></i></a>
                                        <a wire:loading.class="disabled" class="btn btn-warning btn-sm" href='{{route('admin.labor-details.internal-conciliation-builder', $project->laborDetailDesign)}}'" data-toggle="tooltip" data-placement="top" title="Conciliacion interna(Constructor)"><i class="fas fa-clipboard-list"></i></a>
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
            {{ $projects->links() }}
        </div>
    </div>
</div>