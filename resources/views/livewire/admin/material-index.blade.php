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
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 10px">ID</th>
                            <th>Codigo</th>
                            <th>Descripcion</th>
                            <th>Unidad de medida</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($materials as $material)
                            <tr>
                                <td>{{$material->id_mat}}</td>
                                <td>{{$material->code_mat}}</td>
                                <td>{{$material->description_mat}}</td>
                                <td>{{$material->unit_of_measurement_mat}}</td>
                            </tr>    
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                {{ $materials->links() }}
            </div>
        </div>
    </div>
</div>