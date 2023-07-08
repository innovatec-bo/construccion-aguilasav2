@extends('layouts.dashboard-layout')

@section('title', 'Contratos')

@section('breadcrumb')
    {{ Breadcrumbs::render('admin.contracts.index') }}
@stop

@section('content')
    @livewire('admin.contract-index')
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    {{-- <script> console.log('Hi!'); </script> --}}
@stop