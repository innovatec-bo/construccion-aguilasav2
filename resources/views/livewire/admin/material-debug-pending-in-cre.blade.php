<div class="row position-relative">
    <div class="overlay d-none" wire:loading.class.remove="d-none" wire:target="previousPage, nextPage, gotoPage, search, projectCode">
        <div class="spinner-grow" style="width: 3rem; height: 3rem;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <div class="form-group col-2">
        <label for="projectCode" class="mb-0">Proyecto</label>
        <input type="text" class="form-control" wire:model.live.debounce.1500ms="projectCode" id="projectCode" placeholder="Codigo proyecto">
    </div>
    <div class="form-group col">
        <div class="d-grid gap-2 d-md-block">
            <button type="button" class="btn btn-danger mt-4 ms-2" wire:click="$dispatch('showModal', 'admin.material-debug-modal')">Depurar todos</button>
        </div>
    </div>
    <div class="col-md-12 mt-4">
        <div class="card shadow-lg">
            
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover mb-0">
                        <thead>
                            <tr class="text-center">
                                <th>
                                    ID
                                </th>
                                <th>
                                    Proyecto
                                </th>
                                <th>
                                    Estado
                                </th>
                                <th>
                                    Materiales a<br>depurar
                                </th>
                                <th>
                                    Opciones
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $row)
                                <tr>
                                    <td class="text-end">
                                        {{$row['project_id']}}
                                    </td>
                                    <td>
                                        {{$row['project_code']}}
                                    </td>
                                    <td class="">
                                        {{$row['project_status_name']}}
                                    </td>
                                    <td class="text-end"> 
                                        {{count($row['list'])}}
                                         {{-- ({{$row['quantity_debug_pending_in_cre']}}) --}}
                                    </td>
                                    <td class="text-center">
                                        {{-- <button type="button" class="btn btn-secondary" wire:click="$dispatch('showModal', 'admin.material-debug-modal')">Depurar todos</button> --}}
                                        <button class="btn btn-sm btn-secondary" wire:click="$dispatch('showModal', 'admin.material-debug-single-project-modal', {{$row['project_id']}})" type="button">Depurar</button>
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
            {{ $data->links() }}
        </div>
    </div>
</div>
