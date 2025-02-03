@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Detalle usuario</h1>
@stop

@section('content')
    @livewire('admin.user-show', ['user' => $user]);
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    {{-- <script> console.log('Hi!'); </script> --}}
@stop
