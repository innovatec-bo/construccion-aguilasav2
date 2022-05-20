@extends('adminlte::page')

@section('title', 'Movimientos del proyecto '.$project->code_pro)

@section('content_header')
    <h1>Movimientos del proyecto {{$project->code_pro}}</h1>
@stop

@section('content')
    @livewire('admin.material-summary-grouped-movement-details', ['project' => $project])
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    @stack('scripts')    
{{-- <script> console.log('Hi!'); </script> --}}
@stop