@extends('layouts.dashboard-layout')

@section('title', 'Crear material')

@section('breadcrumb')
    {{ Breadcrumbs::render('admin.materials.create') }}
@stop

@section('content')
    @livewire('admin.material-create')
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    @stack('scripts')
    {{-- <script> console.log('Hi!'); </script> --}}
@stop
