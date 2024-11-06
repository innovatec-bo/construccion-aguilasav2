@extends('layouts.dashboard-layout')

@section('title', 'Contratos')

@section('breadcrumb')
    {{ Breadcrumbs::render('admin.contracts.index') }}
@stop

@section('content')
    @livewire('admin.contract-index')
@stop