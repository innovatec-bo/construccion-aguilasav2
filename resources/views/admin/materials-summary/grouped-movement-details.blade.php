@extends('layouts.dashboard-layout')

@section('title', 'Movimientos del proyecto '.$project->code_pro)

{{-- @section('breadcrumb')
    {{ Breadcrumbs::render('admin.materials-summary.grouped-movement-details', $project) }}
@stop --}}

@section('content')
    @livewire('admin.material-summary-grouped-movement-details', ['project' => $project])
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    @stack('scripts')    
{{-- <script> console.log('Hi!'); </script> --}}
@stop