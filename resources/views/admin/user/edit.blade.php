@extends('layouts.dashboard-layout')

@section('title', 'Editar Usuario')

@section('content_header')
    <h1>Editar usuario</h1>
@stop

@section('content')
    <h4 class="py-3 mb-4">
        Editar Usuario
    </h4>
    @livewire('admin.user-edit', ['user' => $user])
@stop

@section('css')
    <link rel="stylesheet" href="{{asset('admin-theme/vendor/css/pages/page-profile.css')}}">
    <link rel="stylesheet" href="{{asset('admin-theme/vendor/libs/bs-stepper/bs-stepper.css')}}">
@stop

@section('js')
    {{-- <script> console.log('Hi!'); </script> --}}
@stop
