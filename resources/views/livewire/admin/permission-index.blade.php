<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card shadow-lg">
            <div class="card-header">
                @can('admin.permissions.create')
                    <a href="{{route('admin.permissions.create')}}" class="btn btn-xs btn-primary">Nuevo</a>    
                @endcan
                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="table_search" class="form-control float-right" wire:model.live.debounce.1500ms="search" placeholder="Buscar..">
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="overlay dark d-none" wire:loading.class="d-flex" wire:target="previousPage, nextPage, gotoPage, search">
                    <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                </div>
                <div class="table-responsive">
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
                                    <td class="text-center">
                                        @can('admin.permissions.edit')
                                            <a class="btn btn-primary btn-sm" href='{{route('admin.permissions.edit', $permission)}}'"><i class="fas fa-pen"></i></a>
                                        @endcan
                                        {{-- @can('admin.permissions.show')
                                            <a class="btn btn-secondary btn-xs" href='{{route('admin.permissions.show', $permission)}}'"><i class="fas fa-eye"></i></a>
                                        @endcan --}}
                                    </td>
                                </tr>    
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer clearfix">
                <div class="table-responsive">
                    {{ $permissions->links() }}
                </div>
            </div>
        </div>
    </div>
</div>