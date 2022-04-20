@extends('adminlte::page')

@section('title', 'Crear material')

@section('content_header')
    <h1>Crear Material</h1>
@stop

@section('content')
    @livewire('admin.material-create')
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    @stack('scripts')
    {{-- <script> console.log('Hi!'); </script> --}}
@stop
