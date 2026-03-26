@extends('layouts.dashboard-layout')

@section('title', 'Estados de proyecto')

{{-- @section('breadcrumb')
    {{ Breadcrumbs::render('admin.users.index') }}
@stop --}}

@section('content')
    @livewire('admin.project-status-index')
@stop

@section('css')
@stop

@section('js')
@stop
