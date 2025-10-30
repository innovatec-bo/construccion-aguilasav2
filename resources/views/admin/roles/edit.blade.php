@extends('layouts.dashboard-layout')

@section('title', 'Editar rol')

@section('content_header')
    <h1>Editar rol</h1>
@stop

@section('content')
    <h4 class="fw-semibold mb-4">Editar Rol</h4>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form method="POST" action="{{ route('admin.roles.update', $role) }}">
                @csrf
                @method('PATCH')

                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name', $role->name) }}"
                                class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                            >
                            @error('name')
                                <small class="text-warning">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-12">
                        @if ($users->count() > 0)
                            <ul class="nav nav-pills mb-3 mt-3" role="tablist">
                                @foreach ($users as $user)
                                    <li class="d-flex align-items-center mb-4">
                                        <div class="avatar-wrapper">
                                            <div class="avatar me-2">
                                                <img class="rounded-circle" src="{{ $user->getFirstMediaUrl('default', 'sm') }}" alt="Avatar" />
                                            </div>
                                        </div>
                                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-3">
                                                <div class="d-flex align-items-center">
                                                    <h6 class="mb-0 me-1">{{ $user->fullName }}</h6>
                                                </div>
                                                <small class="text-muted">CI: {{ $user->identity_number }}</small>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>    
                        @else
                            No existen usuarios con el rol de {{ $role->name }}                                    
                        @endif
                    </div>
                </div>

                <div class="row">
                    @foreach ($permissionsGrouping as $title => $permissions)
                        <div class="col-md-4">
                            <div class="card border-top-primary border-top-3 mb-3 shadow">
                                <div class="card-body text-primary">
                                    <h5 class="card-title">{{ ucfirst($title) }}</h5>
                                    @foreach ($permissions as $key => $permission)
                                        <div class="checkbox">
                                            <label class="" for="permissions_checked_{{ $key }}">
                                                <input
                                                    class=""
                                                    type="checkbox"
                                                    name="permissions_checked[]"
                                                    id="permissions_checked_{{ $key }}"
                                                    value="{{ $key }}"
                                                    {{ $permissionInRole->contains($key) ? 'checked' : '' }}
                                                >
                                                {{ ucfirst($permission) }}
                                            </label>
                                        </div>        
                                    @endforeach
                                </div>
                            </div>
                        </div>    
                    @endforeach
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1 waves-effect waves-light">Guardar</button>
                        <a href="{{ route('admin.roles.index') }}" class="btn btn-label-secondary waves-effect">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    {{-- <script> console.log('Hi!'); </script> --}}
@stop
