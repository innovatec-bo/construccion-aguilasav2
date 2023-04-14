@extends('layouts.dashboard-layout')

@section('title', 'Inicio')

@section('content_header')
<div class="row">
    <div class="col-sm-6">
        <h1>Inicio</h1>
    </div>
    <div class="col-sm-6">
        {{ Breadcrumbs::render('admin.home.index') }}
    </div>
</div>
@stop
@section('breadcrumb')
    {{ Breadcrumbs::render('admin.home.index') }}
@stop
@section('content')
    @livewire('admin.home-index')
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    {{-- <script> console.log('Hi!'); </script> --}}
@stop