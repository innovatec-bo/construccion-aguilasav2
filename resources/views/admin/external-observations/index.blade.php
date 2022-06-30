@extends('adminlte::page')

@section('title', 'Observaciones externas')

@section('content_header')
    <h1>Observaciones externas</h1>
@stop

@section('content')
    @livewire('admin.external-observation-index')
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    {{-- <script> console.log('Hi!'); </script> --}}
@stop