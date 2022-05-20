@extends('adminlte::page')

@section('title', 'Movimientos agrupados por proyectos')

@section('content_header')
    <h1>Movimientos agrupados por proyecto</h1>
@stop

@section('content')
    @livewire('admin.material-summary-grouped-movements')
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    @stack('scripts')    
{{-- <script> console.log('Hi!'); </script> --}}
@stop