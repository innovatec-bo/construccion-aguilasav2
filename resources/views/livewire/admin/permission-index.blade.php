<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header">
                <input class="form-control form-control-sm" type="text" wire:model.debounce.2s="search" placeholder="Buscar..">
            </div>

            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 10px">ID</th>
                            <th>Nombre</th>
                            <th style="width: 130px">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permissions as $permission)
                            <tr>
                                <td>{{$permission->id}}</td>
                                <td>{{$permission->name}}</td>
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