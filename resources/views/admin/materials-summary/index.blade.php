@extends('adminlte::page')

@section('title', 'Listas de movimientos')

@section('content_header')
    <h1>Listas de movimientos</h1>
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