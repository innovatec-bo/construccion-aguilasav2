@extends('adminlte::page')

@section('title', 'Editar de movimiento')

@section('content_header')
    <h1>Editar movimiento</h1>
@stop

@section('content')
    @livewire('admin.material-summary-edit', ['materialsSummary' => $materialsSummary])
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    {{-- <script> console.log('Hi!'); </script> --}}
@stop
