@extends('layouts.dashboard-layout')

@section('title', 'Registro de avance')

@section('breadcrumb')
    {{ Breadcrumbs::render('admin.labor-cost-log.index') }}
@stop

@section('content')
    @livewire('admin.labor-cost-log-index')
@stop

@section('css')
    <link rel="stylesheet" href="{{asset('js/bootstrap-datepicker-1.9.0/css/bootstrap-datepicker3.css')}}">
@stop

@section('js')
    <script src="{{asset('js/bootstrap-datepicker-1.9.0/js/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('js/bootstrap-datepicker-1.9.0/locales/bootstrap-datepicker.es.min.js')}}"></script>
@stop