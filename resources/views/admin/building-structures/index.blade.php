@extends('adminlte::page')

@section('title', 'Estructuras de construccion')

@section('content_header')
    <h1>Estructuras de construccion</h1>
@stop

@section('content')
    @livewire('admin.building-structure-index')
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')  
{{-- <script> console.log('Hi!'); </script> --}}
@stop