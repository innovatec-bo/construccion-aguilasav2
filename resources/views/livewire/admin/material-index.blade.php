<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow-lg">
            <div class="overlay d-none" wire:loading.class.remove="d-none" wire:target="previousPage, nextPage, gotoPage, search">
                <div class="spinner-grow" role="status">
                    <span class="visually-hidden">Loading...</span>
                  </div>
            </div>
            <div class="card-header">
                <input class="form-control form-control-sm" type="text" wire:model.debounce.1500ms="search" placeholder="Buscar..">
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th style="width: 10px">ID</th>
                                <th>Codigo</th>
                                <th>Descripcion</th>
                                <th>Unidad de medida</th>
                                <th>Cantidad en Almac&eacute;n</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($materials as $material)
                                <tr>
                                    <td>{{$material->id_mat}}</td>
                                    <td>{{$material->code_mat}}</td>
                                    <td>{{$material->description_mat}}</td>
                                    <td>{{$material->unit_of_measurement_mat}}</td>
                                    <td>{{number_format($materialQuantity[$material->id_mat]??0.00,2,'.',',')}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer clearfix">
                <div class="table-responsive">
                    {{ $materials->links() }}
                </div>
            </div>
        </div>
    </div>
</div>