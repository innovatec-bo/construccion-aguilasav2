@extends('layouts.dashboard-layout')

@section('title', 'Registrar movimiento')

@section('breadcrumb')
    {{ Breadcrumbs::render('admin.materials-summary.create') }}
@stop

@section('content')
    @livewire('admin.material-summary-create')
@stop

@section('css')
    <link rel="stylesheet" href="{{asset('js/bootstrap-datepicker-1.9.0/css/bootstrap-datepicker3.css')}}">
@stop

@section('js')
    <script src="{{asset('js/bootstrap-datepicker-1.9.0/js/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('js/bootstrap-datepicker-1.9.0/locales/bootstrap-datepicker.es.min.js')}}"></script>
@stop
