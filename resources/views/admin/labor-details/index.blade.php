@extends('layouts.dashboard-layout')

@section('title', 'Manos de obra')

{{-- @section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1>Manos de obra</h1>
        </div>
        <div class="col-sm-6">
            {{ Breadcrumbs::render('admin.labor-details.index') }}
        </div>
    </div>
@stop --}}

@section('breadcrumb')
    {{ Breadcrumbs::render('admin.labor-details.index') }}
@stop

@section('content')
    @livewire('admin.labor-detail-index')
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    {{-- <script> console.log('Hi!'); </script> --}}
@stop