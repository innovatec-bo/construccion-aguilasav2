@extends('layouts.dashboard-layout')

@section('title', 'Proyectos con cronograma de poda')

@section('breadcrumb')
    {{ Breadcrumbs::render('admin.tree-prunings.index') }}
@stop

@section('content')
    @livewire('admin.tree-pruning-index')
@stop