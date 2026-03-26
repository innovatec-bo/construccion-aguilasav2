@extends('layouts.dashboard-layout')

@section('title', 'Editar permiso')

@section('breadcrumb')
    {{ Breadcrumbs::render('admin.permissions.edit', $permission) }}
@stop

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card card-primary shadow-lg">
            <form method="POST" action="{{ route('admin.permissions.update', $permission) }}">
                @csrf
                @method('PATCH')
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label for="name">Nombre</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name', $permission->name) }}"
                            class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                            placeholder="Nombre"
                            required
                        >
                        @error('name')
                            <span class="text-warning small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="detail">Detalle</label>
                        <input
                            type="text"
                            id="detail"
                            name="detail"
                            value="{{ old('detail', $permission->detail) }}"
                            class="form-control{{ $errors->has('detail') ? ' is-invalid' : '' }}"
                            placeholder="Detalle"
                            required
                        >
                        @error('detail')
                            <small class="text-warning">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    {{-- <script> console.log('Hi!'); </script> --}}
@stop
