@extends('layouts.dashboard-layout')

@section('title', 'Cargar balance externo de materiales')

@section('breadcrumb')
    {{ Breadcrumbs::render('admin.external-balance-material.create') }}
@stop

@section('content')
    @livewire('admin.external-balance-material-create')
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
@stop

@section('js')
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    {{-- <script> console.log('Hi!'); </script> --}}
@stop
