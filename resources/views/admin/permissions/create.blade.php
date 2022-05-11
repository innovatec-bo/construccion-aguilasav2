@extends('adminlte::page')

@section('title', 'Nuevo Permiso')

@section('content_header')
    <h1>Nuevo Permiso</h1>
@stop

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card card-primary shadow-lg">
            <form method="post" action="{{route('admin.permissions.store')}}">
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
                    <div class="form-group">
                        {!! Form::label('detail', 'Detalle') !!}
                        {!! Form::text('detail', null, ['class' => 'form-control '.($errors->has('detail') ? ' is-invalid' : '' ), 'required' => 'required']) !!}
                        <small class="text-warning">{{ $errors->first('detail') }}</small>
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
