@extends('adminlte::page')

@section('title', 'Nuevo usuario')

@section('content_header')
    <h1>Nuevo usuario</h1>
@stop

@section('content')
    @livewire('admin.user-create')
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    {{-- <script> console.log('Hi!'); </script> --}}
@stop
