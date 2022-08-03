<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow-lg">
            <div class="card-header">
                @can('admin.roles.create')
                    <a href="{{route('admin.roles.create')}}" class="btn btn-xs btn-primary">Nuevo</a>    
                @endcan
                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="table_search" class="form-control float-right" wire:model.debounce.1500ms="search" placeholder="Buscar..">
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
                                <th style="width: 130px">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                                <tr>
                                    <td>{{$role->id}}</td>
                                    <td>{{$role->name}}</td>
                                    <td class="text-center">
                                        @can('admin.roles.edit')
                                            <a class="btn btn-primary btn-xs" href='{{route('admin.roles.edit', $role)}}'"><i class="fas fa-pen"></i></a>
                                        @endcan
                                        @can('admin.roles.show')
                                            <a class="btn btn-secondary btn-xs" href='{{route('admin.roles.show', $role)}}'"><i class="fas fa-eye"></i></a>
                                        @endcan
                                    </td>
                                </tr>    
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer clearfix">
                <div class="table-responsive">
                    {{ $roles->links() }}
                </div>
            </div>
        </div>
    </div>
</div>