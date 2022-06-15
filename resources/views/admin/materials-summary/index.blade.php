@extends('adminlte::page')

@section('title', 'Listas de movimientos')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1>Listas de movimientos</h1>
        </div>
        <div class="col-sm-6">
            {{ Breadcrumbs::render('admin.materials-summary.index') }}
        </div>
    </div>
@stop

@section('content')
    @livewire('admin.material-summary-index')
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    @stack('scripts')    
{{-- <script> console.log('Hi!'); </script> --}}
@stop