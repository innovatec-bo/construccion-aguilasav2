@extends('layouts.dashboard-layout')

@section('title', 'Reporte de deuda de constructores')

@section('breadcrumb')
    {{ Breadcrumbs::render('admin.builder-debts-report.index') }}
@stop

@section('content')
    @livewire('admin.builder-debt-report-index')
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    {{-- <script> console.log('Hi!'); </script> --}}
@stop
