@extends('layouts.dashboard-layout')

@section('title', 'Editar estructura del proyecto '/* . $laborCost->laborDetail->project->code_pro*/)

@section('breadcrumb')
    {{ Breadcrumbs::render('admin.labor-cost.edit', $laborCost) }}
@stop

{{-- @section('content_header')
    <h1>Editar estructura {{$laborCost->buildingStructure->structure_code_bus}} del proyecto {{ $laborCost->laborDetail->project->code_pro }}</h1>
@stop --}}

@section('content')
    {{-- {{$laborCost->laborDetail->project->code_pro}} --}}
    @livewire('admin.labor-cost-edit', ['laborCost' => $laborCost])
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    @stack('scripts')
    {{-- <script> console.log('Hi!'); </script> --}}
@stop
