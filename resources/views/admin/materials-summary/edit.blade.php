@extends('layouts.dashboard-layout')

@section('title', 'Editar de movimiento')

@section('breadcrumb')
    {{ Breadcrumbs::render('admin.materials-summary.edit', $materialsSummary) }}
@stop

@section('content')
    @livewire('admin.material-summary-edit', ['materialsSummary' => $materialsSummary])
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    {{-- <script> console.log('Hi!'); </script> --}}
@stop
