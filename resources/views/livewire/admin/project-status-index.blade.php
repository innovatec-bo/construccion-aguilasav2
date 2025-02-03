<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card shadow-lg">
            <div class="card-body p-0">
                <div class="overlay d-none" wire:loading.class.remove="d-none" wire:target="previousPage, nextPage, gotoPage, search, toggleResponsible">
                    <div class="spinner-grow" role="status">
                        <span class="visually-hidden">Loading...</span>
                      </div>
                </div>
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

            <div class="card-footer clearfix">
                <div class="table-responsive">
                    {{ $projectStatus->links(data: ['scrollTo' => false]) }}
                </div>
            </div>
        </div>
    </div>
</div>
