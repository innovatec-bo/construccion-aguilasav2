@extends('layouts.dashboard-layout')

@section('title', 'Balance externo de materiales')

@section('breadcrumb')
    {{ Breadcrumbs::render('admin.external-balance.show', $externalBalance) }}
@stop

@section('content')
    @livewire('admin.external-balance-show', ['externalBalance' => $externalBalance])
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    {{-- <script> console.log('Hi!'); </script> --}}
@stop
