@extends('layouts.dashboard-layout')

@section('title', 'Roles')

@section('breadcrumb')
    {{ Breadcrumbs::render('admin.roles.index') }}
@stop

@section('content')
    @livewire('admin.role-index')
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    {{-- <script> console.log('Hi!'); </script> --}}
@stop