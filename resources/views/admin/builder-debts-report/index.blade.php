@extends('adminlte::page')

@section('title', 'Reporte de deuda de constructores')

@section('content_header')
    <h1>Reporte de deuda de constructores</h1>
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
