@extends('adminlte::page')

@section('title', 'Proyectos')

@section('content_header')
    <h1>Proyectos</h1>
@stop

@section('content')
    @livewire('admin.project-index')
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    {{-- <script> console.log('Hi!'); </script> --}}
@stop