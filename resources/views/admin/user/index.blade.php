@extends('layouts.dashboard-layout')

@section('title', 'Usuarios')

@section('breadcrumb')
    {{ Breadcrumbs::render('admin.users.index') }}
@stop

@section('content')
    @livewire('admin.user-index')
@stop

@section('css')
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
@stop

@section('js')
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
@stop
