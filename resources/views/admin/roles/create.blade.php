@extends('layouts.dashboard-layout')

@section('title', 'Nuevo rol')

@section('breadcrumb')
    {{ Breadcrumbs::render('admin.roles.create') }}
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
                    {!! Form::label('name', 'Nombre del Rol') !!}
                    {!! Form::text('name', null, ['class' => 'form-control '.($errors->has('name') ? ' is-invalid' : '' )]) !!}
                        <small class="text-warning">{{ $errors->first('name') }}</small>
                    </div>
                    {!! Form::label('name', 'Permisos') !!}
                    <div class="form-group">
                        <div class="row">
                            @foreach ($permissions as $key => $permission)
                                <div class="col-md-12">
                                    <div class="checkbox">
                                        <label for="permissions_checked_{{$key}}">
                                            {!! Form::checkbox('permissions_checked[]', $key, null, ['id' => 'permissions_checked_'.$key]) !!} {{$permission}}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                            <div class="col-md-12">
                                <small class="text-warning">{{ $errors->first('permissions_checked') }}</small>
                            </div>
                        </div>
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
