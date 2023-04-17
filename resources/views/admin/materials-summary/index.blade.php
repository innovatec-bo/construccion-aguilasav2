@extends('layouts.dashboard-layout')

@section('title', 'Listas de movimientos')

@section('breadcrumb')
    {{ Breadcrumbs::render('admin.materials-summary.index') }}
@stop

@section('content')
    @livewire('admin.material-summary-index')
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    @stack('scripts')
{{-- <script> console.log('Hi!'); </script> --}}
@stop