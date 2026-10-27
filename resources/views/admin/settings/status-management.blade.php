@extends('layouts.dashboard-layout')

@section('title', 'Editar configurar Administracion de estados')

@section('content')
    @livewire('admin.status-management-settings')
@stop

@section('css')
    {{-- <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" /> --}}
@stop

@section('js')
    {{-- <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script> --}}
    <script>
        $(function() {
            // const popoverTriggerList = document.querySelectorAll('[data-coreui-toggle="popover"]')
            // const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new coreui.Popover(popoverTriggerEl));
        });
    </script>
@stop
