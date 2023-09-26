@extends('layouts.dashboard-layout')

@section('title', 'Cargar balance externo de materiales')

@section('breadcrumb')
    {{ Breadcrumbs::render('admin.external-balance-material.create') }}
@stop

@section('content')
    @livewire('admin.external-balance-material-create')
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
