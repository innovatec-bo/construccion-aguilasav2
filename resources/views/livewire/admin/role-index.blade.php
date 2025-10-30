<div class="">
    <div class="overlay" wire:loading.flex wire:target="previousPage, nextPage, gotoPage, search, getVendorInfo">
        <div class="sk-swing sk-primary">
            <div class="sk-swing-dot"></div>
            <div class="sk-swing-dot"></div>
        </div>
    </div>
    <h4 class="fw-semibold mb-4">Lista de roles</h4>
    <div class="row">
        <div class="col-md-2 mb-3">
            <label class="form-label" for="search">Buscar</label>
            <input type="text" id="search" wire:model.live.debounce.1000ms="search" class="form-control">
        </div>
    </div>
    <!-- Role cards -->
    <div class="row g-4">
        
        @foreach ($roles as $role)
            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            @php
                                $users = App\Models\User::role($role->name)->get();
                            @endphp
                            <h6 class="fw-normal mb-2">Total {{ $users->count() }} usuarios</h6>
                            <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
                                @php
                                    $count = 0;
                                @endphp
                                @foreach ($users as $key => $user)
                                    @if ($key < 5)
                                        @php
                                            $abbreviature = strtoupper(substr($user->name, 0, 1));
                                        @endphp
                                        <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="{{ $user->full_name }}" class="avatar avatar-sm pull-up">
                                            <img class="rounded-circle" src="{{ $user->getFirstMediaUrl('default','sm') }}" alt="Avatar" />
                                        </li>
                                    @else
                                        @php
                                            $count++;
                                        @endphp
                                    @endif
                                @endforeach
                                @if ($count > 0)
                                    <li class="avatar avatar-sm">
                                        <span class="avatar-initial rounded-circle pull-up" data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            data-bs-original-title="{{$count}} m&aacute;s">+{{ $count }}</span>
                                    </li>
                                @endif
                            </ul>
                        </div>
                        <div class="d-flex justify-content-between align-items-end mt-1">
                            <div class="role-heading">
                                <h4 class="mb-1">{{ $role->name }}</h4>
                                @can('admin.roles.edit')
                                    <a href="{{ route('admin.roles.edit', $role) }}" class="role-edit-modal"><span>Editar
                                            Rol</span></a>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        @can('admin.roles.create')
            
            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="card h-100">
                    <div class="row h-100">
                        <div class="col-sm-5">
                            <div class="d-flex align-items-end h-100 justify-content-center mt-sm-0 mt-3">
                                <img src="{{ asset('admin-theme/img/illustrations/add-new-roles.png') }}"
                                    class="img-fluid mt-sm-4 mt-md-0" alt="add-new-roles" width="83" />
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="card-body text-sm-end text-center ps-sm-0">
                                {{-- <button data-bs-target="#addRoleModal" data-bs-toggle="modal"
                                    class="btn btn-primary mb-2 text-nowrap add-new-role">
                                    Add New Role
                                </button> --}}
                                <a href="{{route('admin.roles.create')}}" class="btn btn-primary mb-2 text-nowrap add-new-role">Agregar nuevo rol</a>
                                <p class="mb-0 mt-1">Crear un nuevo rol si no existe</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
        
        <div class="col-12">
            <div class="card-footer clearfix">
                <div class="table-responsive">
                    {{ $roles->links() }}
                </div>
            </div>
        </div>
    </div>
    <!--/ Role cards -->
    @push('scripts')
    <script type="module">
        $(document).ready(function(){
            if (typeof window.Livewire !== 'undefined') {
                window.Livewire.hook('message.processed', (message, component) => {
                    $('[data-bs-toggle="tooltip"]').tooltip('dispose').tooltip();
                });
            }
        });
    </script>
    @endpush
</div>