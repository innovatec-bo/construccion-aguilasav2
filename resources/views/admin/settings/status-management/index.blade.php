@extends('layouts.dashboard-layout')

@section('title', 'Configurar Administracion de estados')

@section('breadcrumb')
    {{ Breadcrumbs::render('admin.status-management-settings.index') }}
@stop

@section('content')
    <div class="card mb-4">
        <div class="card-body">
            <form name="add-blog-post-form" id="add-blog-post-form" method="post" action="{{route('admin.status-management-settings.update', $settings)}}">
            <div class="mb-3">
                <label class="form-label d-block" for="exampleFormControlInput1">Aprobaci&oacute;n manual de
                    conciliaci&oacute;n</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" id="inlineRadio1" type="radio" name="inlineRadioOptions1" value="option1">
                    <label class="form-check-label" for="inlineRadio1">Activado</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" id="inlineRadio2" type="radio" name="inlineRadioOptions1" checked value="option2">
                    <label class="form-check-label" for="inlineRadio2">Desactivado</label>
                </div>
                <small class="form-text text-muted d-block">Esta opcion da control al encargado de almacen para definir que
                    proyectos estan aptos para pasar de as built al siguiente estado</small>
            </div>
            <div class="mb-3">
                <label class="form-label d-block" for="exampleFormControlInput1">Denegar As Built si existen materiales pendientes de retiro en CRE</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" id="inlineRadio1" type="radio" name="inlineRadioOptions"
                        value="option1">
                    <label class="form-check-label" for="inlineRadio1">Activado</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" id="inlineRadio2" type="radio" name="inlineRadioOptions" checked
                        value="option2">
                    <label class="form-check-label" for="inlineRadio2">Desactivado</label>
                </div>
                <small class="form-text text-muted d-block">Con esta opcion habilitada, se niega el pase a As Built para todos los proyectos que tengan materiales pendientes de retiro en CRE</small>
            </div>
        </div>
    </div>
    {{-- @livewire('admin.user-index') --}}
@stop

@section('css')
    {{-- <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" /> --}}
@stop

@section('js')
    {{-- <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script> --}}
    <script>
        $(function() {
            // const popoverTriggerList = document.querySelectorAll('[data-coreui-toggle="popover"]')
            // const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new coreui.Popover(popoverTriggerEl));
        });
    </script>
@stop
