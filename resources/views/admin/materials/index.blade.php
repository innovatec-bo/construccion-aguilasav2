@extends('adminlte::page')

@section('title', 'Materiales')

@section('content_header')
    <h1>Materiales</h1>
@stop

@section('content')
    @livewire('datatable', ['model' => 'App\Models\Material', 'name' => 'all-materials', 'exportable' => true])
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    {{-- <script> console.log('Hi!'); </script> --}}
@stop
