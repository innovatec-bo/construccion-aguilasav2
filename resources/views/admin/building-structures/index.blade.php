@extends('layouts.dashboard-layout')

@section('title', 'Estructuras de construccion')

@section('breadcrumb')
    {{ Breadcrumbs::render('admin.building-structures.index') }}
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