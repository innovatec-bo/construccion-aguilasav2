@extends('adminlte::page')

@section('title', 'Manos de obra')

@section('content_header')
    <h1>Manos de obra</h1>
@stop

@section('content')
    @livewire('admin.labor-detail-index')
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    {{-- <script> console.log('Hi!'); </script> --}}
@stop
