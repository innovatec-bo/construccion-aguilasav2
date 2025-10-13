@extends('layouts.dashboard-layout')

@section('title', 'Poda de arboles')

@section('breadcrumb')
    {{ Breadcrumbs::render('admin.tree-prunings.index') }}
@stop

@section('content')
    {{-- @livewire('admin.contract-index') --}}
@stop