<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card shadow-lg">
            <div class="overlay d-none" wire:loading.class.remove="d-none" wire:target="previousPage, nextPage, gotoPage, search">
                <div class="spinner-grow" style="width: 3rem; height: 3rem;" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            {{-- <div class="card-header py-4">
                <div class="row">
                    <div class="form-check ms-2">
                        <input type="checkbox" class="form-check-input" id="groupByProject" wire:model="groupByProject">
                        <label class="form-check-label" for="groupByProject">Agrupar por proyecto <i  id="popover" class="fas fa-info-circle"></i></label>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-2">
                        <label for="projectCode" class="mb-0">Proyecto</label>
                        <input type="text" class="form-control" wire:model.debounce.1500ms="projectCode" id="projectCode" placeholder="Codigo proyecto">
                    </div>
                    <div class="form-group col-2">
                        <label for="projectStatusId" class="mb-0">Estado</label>
                        <select class="form-control" wire:model="projectStatusId" id="projectStatusId">
                            <option value="">Estado del proyecto</option>
                            @foreach ($projectStatus as $status)
                                <option value="{{$status->id_pst}}">{{$status->status_name_pst}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-2">
                        <label for="materialCode" class="mb-0">Mat. Codigo</label>
                        <input type="text" class="form-control"  wire:model.debounce.1500ms="materialCode" id="materialCode" placeholder="Codigo material">
                    </div>
                    <div class="form-group col-2">
                        <label for="search" class="mb-0">Mat. Descripcion</label>
                        <input type="text" class="form-control"  wire:model.debounce.1500ms="search" id="search" placeholder="Descripcion material">
                    </div>
                    <div class="form-group col">
                        <div class="d-grid gap-2 d-md-block">
                            <button type="button" wire:click="resetFilters" class="btn btn-primary mt-4">Quitar filtros</button>
                            <button type="button" class="btn btn-danger mt-4 ms-2" wire:click="$emit('showModal', 'admin.material-debug-modal')">Depurar</button>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="card-body p-0 position-relative">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover table-sm mb-0">
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
                            @dd($row)
                                <tr>
                                    <td class="text-end">
                                        {{$row['project']->project_id}}
                                    </td>
                                    <td>
                                    </td>
                                    <td class="">
                                    </td>
                                    <td class="text-end"> 
                                    </td>
                                    <td class="text-end">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer clearfix">
                <div class="table-responsive">
                    {{ $data->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
