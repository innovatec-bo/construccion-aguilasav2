@extends('adminlte::page')

@section('title', 'Inicio')

@section('content_header')
<div class="row">
    <div class="col-sm-6">
        <h1>Inicio</h1>
    </div>
    <div class="col-sm-6">
        {{ Breadcrumbs::render('admin.home.index') }}
    </div>
</div>
@stop

@section('content')
    <p>Pagina principal del sistema</p>
    
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    {{-- <script> console.log('Hi!'); </script> --}}
@stop