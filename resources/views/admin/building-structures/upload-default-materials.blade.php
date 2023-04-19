@extends('layouts.dashboard-layout')

@section('title', 'Establecer materiales')

@section('breadcrumb')
    {{ Breadcrumbs::render('admin.building-structures.upload-default-materials') }}
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
