@extends('adminlte::page')

@section('title', 'Editar permiso')

@section('content_header')
    <h1>Editar Permiso</h1>
@stop

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card card-primary">
            <form method="post" action="{{route('admin.permissions.update', $permission)}}">
                @csrf
                @method('patch')
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Nombre</label>
                        <input type="text" id="name" class="form-control" placeholder="Nombre" name="name" value="{{$permission->name}}">
                        @error('name')
                            <span class="text-danger small"> {{$message}} </span>
                        @enderror
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a href="{{route('admin.permissions.index')}}" class="btn btn-secondary">Cancelar</a>
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
