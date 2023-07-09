@extends('layouts.dashboard-layout')

@section('title', 'Editar contrato')

@section('breadcrumb')
    {{ Breadcrumbs::render('admin.contracts.edit', $contract) }}
@stop

@section('content')
@livewire('admin.contract-edit-modal', ['contract' => $contract])
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    {{-- <script> console.log('Hi!'); </script> --}}
@stop
