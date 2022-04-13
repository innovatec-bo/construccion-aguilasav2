@extends('adminlte::page')

@section('title', 'Establecer materiales')

@section('content_header')
    <h1>Establecer materiales</h1>
@stop

@section('content')
    @livewire('admin.building-structure-upload-default-material')
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    @stack('scripts')
    {{-- <script> console.log('Hi!'); </script> --}}
@stop
