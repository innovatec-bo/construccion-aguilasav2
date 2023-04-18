@extends('layouts.dashboard-layout')

@section('title', 'Depurar materiales')

@section('breadcrumb')
    {{ Breadcrumbs::render('admin.materials.debug') }}
@stop

@section('content')
    @livewire('admin.material-debug')
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    @stack('scripts')
    {{-- <script> console.log('Hi!'); </script> --}}
@stop
