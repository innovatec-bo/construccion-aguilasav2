@extends('adminlte::page')

@section('title', 'Editar estructura del proyecto ' . $laborCost->laborDetail->project->code_pro)

@section('content_header')
    <h1>Editar estructura {{$laborCost->buildingStructure->structure_code_bus}} del proyecto {{ $laborCost->laborDetail->project->code_pro }}</h1>
@stop

@section('content')
    @livewire('admin.labor-cost-edit', ['laborCost' => $laborCost])
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    @stack('scripts')
    {{-- <script> console.log('Hi!'); </script> --}}
@stop
