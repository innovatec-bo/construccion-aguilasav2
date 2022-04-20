@extends('adminlte::page')

@section('title', 'Materiales')

@section('content_header')
    <h1>Materiales</h1>
@stop

@section('content')
    {{-- @livewire('datatable', ['model' => 'App\Models\User', 'name' => 'all-materials', 'exportable' => true]) --}}
    <livewire:datatable
    model="App\Models\User"
    {{-- with="planet, planet.region" --}}
    sort="first_name|asc"
    include="id_usr, first_name, last_name, email"
    searchable="first_name, last_name, email"
    {{-- hide="latitude, longitude" --}}
    dates="created_at"
    {{-- times="bedtime|g:i A" --}}
    {{-- hideable="select" --}}
    exportable
/>
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/1.9.2/tailwind.min.css" integrity="sha512-l7qZAq1JcXdHei6h2z8h8sMe3NbMrmowhOl+QkP3UhifPpCW2MC4M0i26Y8wYpbz1xD9t61MLT9L1N773dzlOA==" crossorigin="anonymous" />
@stop

@section('js')
    {{-- <script> console.log('Hi!'); </script> --}}
@stop
