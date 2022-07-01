@extends('adminlte::page')

@section('title', 'Nueva observacion')

@section('content_header')
    <h1>Nueva observaci&oacute;n</h1>
@stop

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card card-primary shadow-lg">
            <div class="card-body">
                {!! Form::open(['method' => 'POST', 'route' => 'admin.external-observations.store', 'class' => '']) !!}
                    <div class="form-group">
                        {!! Form::label('code_pro', 'Proyecto') !!}
                        {!! Form::text('code_pro', null, ['class' => 'form-control '.( $errors->has('code_pro') ? ' is-invalid' : ''), 'required' => 'required']) !!}
                        @error('code_pro')
                            <small class="text-warning">{{ $message }}</small>    
                        @enderror
                    </div>

                    <div class="form-group">
                        {!! Form::label('fiscal_id_efo', 'Fiscal de CRE') !!}
                        {!! Form::select('fiscal_id_efo', $fiscals, null, ['id' => 'fiscal_id_efo', 'class' => 'form-control '.( $errors->has('fiscal_id_efo') ? ' is-invalid' : ''), 'required' => 'required']) !!}
                        @error('fiscal_id_efo')
                            <small class="text-warning">{{ $message }}</small>    
                        @enderror
                    </div>

                    <div class="form-group">
                        {!! Form::label('observation_efo', "Observaci&oacute;n") !!}
                        {!! Form::textarea('observation_efo', null, ['class' => 'form-control '.( $errors->has('observation_efo') ? ' is-invalid' : ''), 'required' => 'required', 'rows' => '5']) !!}
                        @error('observation_efo')
                            <small class="text-warning">{{ $message }}</small>    
                        @enderror
                    </div>
                    <div class="form-group">
                        {!! Form::label('entry_date_efo', "Fecha de observaci&oacute;n") !!}
                        {!! Form::text('entry_date_efo', date('d/m/Y H:i:s'), ['class' => 'form-control '.( $errors->has('entry_date_efo') ? ' is-invalid' : ''), 'required' => 'required', 'placeholder' => "dd/mm/yyyy hh:mm:ss", "data-inputmask-alias" => "datetime", 'data-inputmask-inputformat' => "dd/mm/yyyy HH:MM:ss", 'inputmode' => 'numeric']) !!}
                        @error('entry_date_efo')
                            <small class="text-warning">{{ $message }}</small>    
                        @enderror
                    </div>
                    <div class="btn-group pull-right">
                        {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
                        <a class="btn btn-danger" href="{{url()->previous()}}">Cancelar</a>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    {{-- <script> console.log('Hi!'); </script> --}}
    <script>
        $('[data-inputmask-alias]').inputmask();
    </script>
@stop
