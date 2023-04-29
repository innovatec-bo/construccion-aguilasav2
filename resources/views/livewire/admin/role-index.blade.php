<div class="row justify-content-center">
    <style>
        .avatar-group .avatar img,
        .avatar-group .avatar .avatar-initial {
            border: 2px solid #fff;
        }

        .pull-up {
            transition: all .25s ease;
        }

        .pull-up:hover {
            transform: translateY(-4px) scale(1.02);
            box-shadow: 0 0.25rem 1rem rgb(161 172 184 / 45%);
            z-index: 30;
            border-radius: 50%;
        }
    </style>
    <div class="col-md-12">
        <div class="card shadow-lg">
            <div class="card-header">
                @can('admin.roles.create')
                    <a href="{{ route('admin.roles.create') }}" class="btn btn-xs btn-primary">Nuevo</a>
                @endcan
                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="table_search" class="form-control float-right"
                            wire:model.debounce.1500ms="search" placeholder="Buscar..">
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="overlay dark d-none" wire:loading.class="d-flex"
                    wire:target="previousPage, nextPage, gotoPage, search">
                    <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                </div>
                <div class="row">
                    @foreach ($roles as $role)
                        <div class="col-md-4">
                            <div class="card border-top-light border-top-3 mb-3">
                                <div class="card-header">Total: 5 usuarios</div>
                                <div class="card-body">
                                    <h5 class="card-title">{{ $role->name }}</h5>
                                    {{-- <p class="card-text">Editar rol</p> --}}
                                    @can('admin.roles.edit')
                                            <a class="" href='{{ route('admin.roles.edit', $role) }}'">Editar</a>
                                        @endcan
                                    @can('admin.roles.show')
                                        <a class="ms-2" href='{{ route('admin.roles.show', $role) }}'">Ver</a>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    @endforeach
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
                                    <td>{{ $role->id }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td class="text-center">
                                        @can('admin.roles.edit')
                                            <a class="btn btn-primary btn-sm"
                                                href='{{ route('admin.roles.edit', $role) }}'"><i
                                                    class="fas fa-pen"></i></a>
                                        @endcan
                                        @can('admin.roles.show')
                                            <a class="btn btn-secondary btn-sm"
                                                href='{{ route('admin.roles.show', $role) }}'"><i
                                                    class="fas fa-eye"></i></a>
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
                    <ul class="list-unstyled avatar-group">
                        <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                            title="Vinnie Mostowy" class="avatar pull-up">
                            <img class="rounded-circle" src="https://dummyimage.com/40x40/f0f0f0.jpg&text=JC"
                                alt="Avatar">
                        </li>
                        <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                            title="Allen Rieske" class="avatar pull-up">
                            <img class="rounded-circle" src="https://dummyimage.com/40x40/f0f0f0.jpg&text=JC"
                                alt="Avatar">
                        </li>
                        <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                            title="Julee Rossignol" class="avatar pull-up">
                            <img class="rounded-circle" src="https://dummyimage.com/40x40/f0f0f0.jpg&text=JC"
                                alt="Avatar">
                        </li>
                        <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                            title="Darcey Nooner" class="avatar pull-up">
                            <img class="rounded-circle" src="https://dummyimage.com/40x40/f0f0f0.jpg&text=JC"
                                alt="Avatar">
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
