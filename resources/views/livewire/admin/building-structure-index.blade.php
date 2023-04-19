<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <input class="form-control form-control-sm" type="text" wire:model.debounce.2s="search" placeholder="Buscar..">
            </div>

            <div class="card-body">
                <div class="overlay dark d-none" wire:loading.class="d-flex" wire:target="delete, previousPage, nextPage, gotoPage, search">
                    <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover table-sm">
                        <thead>
                            <tr>
                                <th>CODIGO</th>
                                <th>DESCRIPCION</th>
                                <th>UNIDAD<br>DE MEDIDA</th>
                                <th>Materiales</th>
                                <th style="width: 130px">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($buildingStructureList as $buildingStructure)
                                <tr>
                                    <td>{{$buildingStructure->structure_code_bus}}</td>
                                    <td>{{$buildingStructure->description_bus}}</td>
                                    <td>{{$buildingStructure->unit_of_measurement_bus}}</td>
                                    <th>{{$buildingStructure->defaultStructureMaterials->count()}}</th>
                                    <td class="text-center">
                                        <button type="button" wire:loading.class="disabled" class="btn btn-secondary btn-sm" onclick="window.location.href='{{route('admin.building-structures.show', $buildingStructure)}}'"><i class="fas fa-eye"></i></button>
                                    </td>
                                </tr>    
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer clearfix">
                <div class="table-responsive">
                    {{ $buildingStructureList->links() }}
                </div>
            </div>
        </div>
    </div>
</div>