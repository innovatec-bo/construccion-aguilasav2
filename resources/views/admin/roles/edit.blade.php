@extends('adminlte::page')

@section('title', 'Editar rol')

@section('content_header')
    <h1>Editar rol</h1>
@stop

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card card-primary shadow-lg">
            <form method="post" action="{{route('admin.roles.update', $role)}}">
                @csrf
                @method('patch')
                <div class="card-body">
                    <div class="form-group">
                        {!! Form::label('name', 'Nombre') !!}
                        {!! Form::text('name', $role->name, ['class' => 'form-control '.($errors->has('name') ? ' is-invalid' : '')]) !!}
                        <small class="text-warning">{{ $errors->first('name') }}</small>
                    </div>
    
                    <div class="form-group">
                        <div class="row">
                            @foreach ($permissions as $key => $permission)
                                <div class="col-sm-4">
                                    <div class="checkbox">
                                        <label for="permissions_checked_{{$key}}">
                                            {!! Form::checkbox('permissions_checked[]', $key, $permissionInRole->contains($key), ['id' => 'permissions_checked_'.$key]) !!} {{$permission}}
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
