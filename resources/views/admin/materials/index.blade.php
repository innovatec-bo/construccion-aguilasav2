@extends('layouts.dashboard-layout')

@section('title', 'Materiales')

@section('breadcrumb')
    {{ Breadcrumbs::render('admin.materials.index') }}
@endsection

@section('content')
    @livewire('admin.material-index')
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    {{-- <script> console.log('Hi!'); </script> --}}
@stop
