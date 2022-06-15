@extends('adminlte::page')

@section('title', 'Movimientos agrupados por proyectos')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1>Movimientos agrupados por proyecto</h1>
        </div>
        <div class="col-sm-6">
            {{ Breadcrumbs::render('admin.materials-summary.grouped-movements') }}
        </div>
    </div>
@stop

@section('content')
    @livewire('admin.material-summary-grouped-movements')
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    @stack('scripts')    
{{-- <script> console.log('Hi!'); </script> --}}
@stop