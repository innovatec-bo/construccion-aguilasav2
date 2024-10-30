@extends('layouts.dashboard-layout')

@section('title', 'Balance externo de materiales')

{{-- @section('breadcrumb')
    {{ Breadcrumbs::render('admin.external-balance.index') }}
@stop --}}

@section('content')
    @livewire('admin.external-balance-index')
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
@stop

@section('js')
    <script type="module" src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    {{-- <script> console.log('Hi!'); </script> --}}
@stop
