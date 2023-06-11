@extends('layouts.dashboard-layout')

@section('title', 'Listas de movimientos')

@section('breadcrumb')
    {{ Breadcrumbs::render('admin.materials-summary.index') }}
@stop

@section('content')
    @livewire('admin.material-summary-index')
@stop

@section('css')
    <link rel="stylesheet" href="{{asset('js/bootstrap-datepicker-1.9.0/css/bootstrap-datepicker3.css')}}">
@stop

@section('js')
    <script src="{{asset('js/bootstrap-datepicker-1.9.0/js/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('js/bootstrap-datepicker-1.9.0/locales/bootstrap-datepicker.es.min.js')}}"></script>
@stop