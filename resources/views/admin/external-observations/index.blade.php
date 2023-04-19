@extends('layouts.dashboard-layout')

@section('title', 'Observaciones externas')

@section('breadcrumb')
    {{ Breadcrumbs::render('admin.external-observations.index') }}
@stop

@section('content')
    @livewire('admin.external-observation-index')
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    {{-- <script> console.log('Hi!'); </script> --}}
@stop