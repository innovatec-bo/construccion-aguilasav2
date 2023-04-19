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
    <script src="{{asset('bootstrap-datepicker-1.9.0-dist/js/bootstrap-datepicker.js')}}"></script>
    
@stop