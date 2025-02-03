@extends('layouts.dashboard-layout')

@section('title', 'Nuevo usuario')

@section('breadcrumb')
    {{ Breadcrumbs::render('admin.users.create') }}
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
