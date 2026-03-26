@extends('layouts.dashboard-layout')

@section('title', 'Registro de podas')

@section('content_header')
    <h1>Registro de podas</h1>
@stop

@section('content')
    @livewire('admin.tree-pruning-form', ['projectBudget' => $projectBudget])
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    {{-- <script> console.log('Hi!'); </script> --}}
@stop
