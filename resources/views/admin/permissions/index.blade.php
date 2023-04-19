@extends('layouts.dashboard-layout')

@section('title', 'Permisos')

@section('breadcrumb')
    {{ Breadcrumbs::render('admin.permissions.index') }}
@stop

@section('content')
    @livewire('admin.permission-index')
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    {{-- <script> console.log('Hi!'); </script> --}}
@stop