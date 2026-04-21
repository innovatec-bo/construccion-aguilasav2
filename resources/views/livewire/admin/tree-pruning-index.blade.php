<div class="row position-relative">
    <div class="overlay d-none" wire:loading.class.remove="d-none" wire:target="previousPage, nextPage, gotoPage, projectCode">
        <div class="spinner-grow" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
    </div>
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
        <div class="d-flex flex-column justify-content-center">
            <h4 class="mb-1">Proyectos con cronograma de poda</h4>
        </div>
    </div>

    <div class="col-md-2">
        <div class="form-group">
            <label>COD Proyecto</label>
            <input type="text" class="form-control form-control-sm" wire:model.live.debounce.1500ms="projectCode">
            @error('projectCode')
                <span class="text-danger small">{{$message}}</span>
            @enderror
        </div>
    </div>
    
    <div class="col-md-12 mt-3">
        <div class="card shadow-lg">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm table-hover table-striped mb-0 small">
                        <thead>
                            <tr>
                                <th>Proyecto</th>
                                <th>Estado actual</th>
                                <th>Estaqueador</th>
                                <th>Arboles<br>registrados</th>
                                <th style=""><i class="ti ti-dots-vertical"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($budgets as $budget)
                                <tr>
                                    <td>
                                        @if ($budget->project)
                                            {{ $budget->project->code_pro }}
                                        @else
                                            No identificado
                                        @endif
                                    </td>
                                    <td>
                                        @if ($budget->project)
                                            {{ $budget->project->status->status_name_pst }}
                                        @else
                                            No identificado
                                        @endif
                                    </td>
                                    <td>
                                        @if ($budget->project)
                                            {{$budget->project->statusDetail(2)['responsible']}}
                                        @else
                                            No identificado
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($budget->treePruning->count() == 0)
                                            <span class="text-danger fw-bold">Sin registros</span>
                                        @elseif ($budget->treePruning->count() > 0)
                                            {{$budget->treePruning->count()}}
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></button>
                                            <div class="dropdown-menu" style="">
                                                <a class="dropdown-item waves-effect" wire:loading.class="disabled" target="_blank" href="{{route('admin.tree-prunings.form', $budget)}}">
                                                    <i class="ti ti-eye me-1"></i> Ver detalle
                                                </a>
                                            </div>
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
            {{ $budgets->links(data: ['scrollTo' => false]) }}
        </div>
    </div>
</div>