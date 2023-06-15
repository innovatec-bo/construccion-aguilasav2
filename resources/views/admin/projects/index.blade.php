@extends('layouts.dashboard-layout')

@section('title', 'Proyectos')

@section('breadcrumb')
    {{ Breadcrumbs::render('admin.projects.index') }}
@stop

@section('content')
    {{-- @livewire('admin.project-index') --}}
    @livewire('admin.project-index2')
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    {{-- <script> console.log('Hi!'); </script> --}}
@stop