@extends('layouts.dashboard-layout')

@section('title', 'Configuracion basica del sistema')

@section('content')
    @livewire('admin.system-settings')
@stop

@section('css')
    {{-- <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" /> --}}
@stop

@section('js')

@stop
