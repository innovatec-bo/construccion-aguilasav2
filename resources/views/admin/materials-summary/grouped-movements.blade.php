@extends('layouts.dashboard-layout')

@section('title', 'Movimientos agrupados por proyectos')

{{-- @section('breadcrumb')
    {{ Breadcrumbs::render('admin.materials-summary.grouped-movements') }}
@stop --}}

@section('content')
    @livewire('admin.material-summary-grouped-movements')
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    @stack('scripts')    
{{-- <script> console.log('Hi!'); </script> --}}
@stop