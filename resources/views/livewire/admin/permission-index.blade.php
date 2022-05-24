<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow-lg">
            <div class="card-header">
                <a href="{{route('admin.permissions.create')}}" class="btn btn-sm btn-primary mb-2">Nuevo permiso</a>
                <input class="form-control form-control-sm" type="text" wire:model.debounce.2s="search" placeholder="Buscar..">
            </div>

            <div class="card-body">
                <div class="overlay dark d-none" wire:loading.class="d-flex" wire:target="previousPage, nextPage, gotoPage, search">
                    <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                </div>
                <table class="table table-bordered table-hover table-striped table-sm">
                    <thead>
                        <tr>
                            <th style="width: 10px">ID</th>
                            <th>Nombre</th>
                            <th>Detalle</th>
                            <th style="width: 130px">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permissions as $permission)
                            <tr>
                                <td>{{$permission->id}}</td>
                                <td>{{$permission->name}}</td>
                                <td>{{$permission->detail}}</td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm" onclick="window.location.href='{{route('admin.permissions.edit', $permission)}}'"><i class="fas fa-pen"></i></button>
                                    <button type="button" class="btn btn-secondary btn-sm" onclick="window.location.href='{{route('admin.permissions.show', $permission)}}'"><i class="fas fa-eye"></i></button>
                                </td>
                            </tr>    
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                {{ $permissions->links() }}
            </div>
        </div>
    </div>
</div>