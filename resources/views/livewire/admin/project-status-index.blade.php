<div class="row position-relative">
    <div class="overlay d-none" wire:loading.class.remove="d-none" wire:target="previousPage, nextPage, gotoPage, projectCode, workAreaSelected, statusSelected">
        <div class="spinner-grow" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
    </div>
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
        <div class="d-flex flex-column justify-content-center">
          <h4 class="mb-1">Estados de los proyectos</h4>
          <p class="mb-0">Listado de todos los estados por los que pasan los proyectos</p>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label>Nombre del estado</label>
            <input type="text" name="table_search" class="form-control form-control-sm" wire:model.live.debounce.1500ms="search" placeholder="Buscar..">
        </div>
    </div>

    <div class="col-md-12 mt-4">
        <div class="card shadow-lg">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover mb-0">
                        <thead>
                            <tr>
                                <th style="width: 10px">ID</th>
                                <th>Orden</th>
                                <th>Nombre</th>
                                <th>Clave</th>
                                <th>Responsables</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($projectStatus as $status)
                                <tr>
                                    <td>{{ $status->id_pst }}</td>
                                    <td>{{ $status->order_pst}} </td>
                                    <td>{{ $status->status_name_pst }}</td>
                                    <td>{{ $status->keyword_pst }}</td>
                                    <td>
                                        <ol>
                                            @foreach ($status->responsibles as $user)
                                                <li>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" wire:click="toggleResponsible({{$user->pivot->id_sre}})" id="check-{{$user->pivot->id_sre}}" {{$user->pivot->active_sre?'checked':''}}>
                                                        <label class="form-check-label" for="check-{{$user->pivot->id_sre}}">
                                                            {{$user->full_name}}
                                                        </label>
                                                      </div>
                                                </li>
                                            @endforeach
                                        </ol>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- <div class="card-footer clearfix">
                <div class="table-responsive">
                    {{ $projectStatus->links(data: ['scrollTo' => false]) }}
                </div>
            </div> --}}
        </div>
    </div>
    <div class="col-md-12 mt-4">
        <div class="table-responsive">
            {{ $projectStatus->links(data: ['scrollTo' => false]) }}
        </div>
    </div>
</div>
