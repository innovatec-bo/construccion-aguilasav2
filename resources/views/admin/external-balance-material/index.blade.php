@extends('layouts.dashboard-layout')

@section('title', 'Usuarios')

@section('breadcrumb')
    {{ Breadcrumbs::render('admin.users.index') }}
@stop

@section('content')
    @livewire('admin.user-index')
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    {{-- <script> console.log('Hi!'); </script> --}}
@stop
