@extends('adminlte::page')

@section('title', 'Depurar materiales')

@section('content_header')
<div class="row">
    <div class="col-sm-6">
        <h1>Depurar materiales</h1>
    </div>
    <div class="col-sm-6">
        {{ Breadcrumbs::render('admin.materials.debug') }}
    </div>
</div>
@stop

@section('content')
    @livewire('admin.material-debug')
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    @stack('scripts')
    {{-- <script> console.log('Hi!'); </script> --}}
@stop
