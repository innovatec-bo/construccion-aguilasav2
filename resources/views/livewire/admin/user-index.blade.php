<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card shadow-lg">
            <div class="card-header">
                @can('admin.users.create')
                    <a href="{{route('admin.users.create')}}" class="btn btn-xs btn-primary">Nuevo</a>    
                @endcan
                <div class="card-tools">
                    <div class="input-group input-group-sm" style="">
                        <input type="text" name="table_search" class="form-control float-right" wire:model.debounce.1500ms="search" placeholder="Buscar..">
                        @can('admin.users.export')
                            <button class="btn btn-primary btn-xs" wire:click="export"><i class="far fa-file-excel"></i> Exportar</button>
                        @endcan
                        
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="overlay dark d-none" wire:loading.class="d-flex"
                    wire:target="previousPage, nextPage, gotoPage, search">
                    <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover table-sm">
                        <thead>
                            <tr>
                                <th style="width: 10px">ID</th>
                                <th>Nombre completo</th>
                                <th>Correo</th>
                                <th>Roles</th>
                                <th style="width: 130px">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->id_usr }}</td>
                                    <td>{{ $user->full_name }}</td>
                                    <td>{{ $user->email_usr }}</td>
                                    <td>
                                        @foreach ($user->getRoleNames() as $role)
                                            <span class="badge bg-primary">{{$role}}</span>
                                        @endforeach
                                    </td>
                                    <td class="text-center">
                                        @can('admin.users.edit')
                                            <a wire:loading.class="disabled" class="btn btn-primary btn-sm" href='{{ route('admin.users.edit', $user) }}'"><i class="fas fa-pen"></i></a>    
                                        @endcan
                                        @can('admin.users.show')
                                            <a wire:loading.class="disabled" class="btn btn-secondary btn-sm" href='{{ route('admin.users.show', $user) }}'"><i class="fas fa-eye"></i></a>    
                                        @endcan
                                        @can('admin.users.destroy')
                                            <form method="post" action="{{ route('admin.users.destroy', $user) }}"
                                                class="d-inline">
                                                @method('delete')
                                                @csrf
                                                <button wire:loading.class="disabled" type="submit" onclick="return confirm('Eliminar?')" class="btn btn-danger btn-sm"><i
                                                        class="fas fa-trash-alt"></i></button>
                                            </form>    
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
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
