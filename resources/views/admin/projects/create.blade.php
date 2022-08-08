@extends('adminlte::page')

@section('title', 'Nuevo Proyecto')

@section('content_header')
    <h1>Nuevo Proyecto</h1>
@stop

@section('content')
    @livewire('admin.project-create')
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    {{-- <script> console.log('Hi!'); </script> --}}
@stop
