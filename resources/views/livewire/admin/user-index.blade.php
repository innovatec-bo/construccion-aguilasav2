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
                            <th>Nombre completo</th>
                            <th>Correo</th>
                            <th>Roles</th>
                            <th style="width: 130px">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{$user->id_usr}}</td>
                                <td>{{$user->full_name}}</td>
                                <td>{{$user->email}}</td>
                                <td>
                                    @foreach ($user->getRoleNames() as $role)
                                        <span class="badge bg-primary">{{$role}}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm" onclick="window.location.href='{{route('admin.users.edit', $user)}}'"><i class="fas fa-pen"></i></button>
                                    <button type="button" class="btn btn-secondary btn-sm" onclick="window.location.href='{{route('admin.users.show', $user)}}'"><i class="fas fa-eye"></i></button>
                                    <form method="post" action="{{route('admin.users.destroy',$user)}}" class="d-inline">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                    
                                </td>
                            </tr>    
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>