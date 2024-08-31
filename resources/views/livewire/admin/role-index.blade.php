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
                            wire:model.live.debounce.1500ms="search" placeholder="Buscar..">
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
                                @php
                                    $users = App\Models\User::role($role->name)->get();
                                @endphp
                                <div class="card-body position-relative">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="fw-normal mb-2">Total: {{ count($users) }} usuarios</h6>
                                        <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
                                            @php
                                                $count = 0;
                                            @endphp
                                            @foreach ($users as $key => $user)
                                                @if ($key < 5)
                                                    @php
                                                        $abbreviature = strtoupper(substr($user->firstname_usr, 0, 1) . substr($user->lastname_usr, 0, 1));
                                                    @endphp
                                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                        data-bs-placement="top" class="avatar avatar-sm pull-up" title="{{ $user->fullName }}"
                                                        aria-label="{{ $user->fullName }}" data-bs-original-title="{{ $user->fullName }}">
                                                        <img class="rounded-circle" src="https://dummyimage.com/32x32/f0f0f0.jpg&text={{$abbreviature}}" alt="Avatar">
                                                    </li>
                                                @else
                                                    @php
                                                        $count++
                                                    @endphp
                                                @endif
                                            @endforeach
                                            @if ($count > 0)
                                                <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                    data-bs-placement="top" class="avatar avatar-sm pull-up" title="+{{$count}}"
                                                    aria-label="+{{$count}}" data-bs-original-title="+{{$count}}">
                                                    <img class="rounded-circle" src="https://dummyimage.com/32x32/f0f0f0.jpg&text={{'+'.$count}}" alt="Avatar">
                                                </li>
                                            @endif
                                        </ul>
                                        
                                    </div>
                                    <div class="d-flex justify-content-between align-items-end mt-1">
                                        <div class="role-heading">
                                            <h4 class="mb-1">{{$role->name}}</h4>
                                            @can('admin.roles.edit')
                                                <a href="{{ route('admin.roles.edit', $role) }}" class="role-edit-modal"><span>Edit Role</span></a>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="table-responsive d-none">
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
                </div>
            </div>
        </div>
    </div>
</div>
