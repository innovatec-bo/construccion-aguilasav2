@extends('adminlte::page')

@section('title', 'Nuevo rol')

@section('content_header')
    <h1>Nuevo Rol</h1>
@stop

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card card-primary shadow-lg">
            <form method="post" action="{{route('admin.roles.store')}}">
                @csrf
                @method('post')
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Nombre</label>
                        <input type="text" id="name" class="form-control" placeholder="Nombre" name="name">
                        @error('name')
                            <span class="text-warning small"> {{$message}} </span>
                        @enderror
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a href="{{route('admin.roles.index')}}" class="btn btn-secondary">Cancelar</a>
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
