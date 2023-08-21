@extends('layouts.dashboard-layout')

@section('title', 'Editar configurar Administracion de estados')

@section('breadcrumb')
    {{ Breadcrumbs::render('admin.status-management-settings.edit') }}
@stop

@section('content')
    <div class="card mb-4">
        <div class="card-body">
            <form name="add-blog-post-form" id="add-blog-post-form" method="post" action="{{route('admin.status-management-settings.update')}}">
                @method('post')
                @csrf
                <div class="mb-3">
                    <label class="form-label d-block" for="exampleFormControlInput1">Aprobaci&oacute;n manual de
                        conciliaci&oacute;n</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" id="enable_manual_approvement_for_conciliations1" type="radio" name="enable_manual_approvement_for_conciliations" value="1" {{ old('enable_manual_approvement_for_conciliations', $statusManagementSettings->enable_manual_approvement_for_conciliations)== "1" ? 'checked' : '' }}>
                        <label class="form-check-label" for="enable_manual_approvement_for_conciliations1">Activado</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" id="enable_manual_approvement_for_conciliations2" type="radio" name="enable_manual_approvement_for_conciliations" value="0" {{ old('enable_manual_approvement_for_conciliations', $statusManagementSettings->enable_manual_approvement_for_conciliations)== "0" ? 'checked' : '' }}>
                        <label class="form-check-label" for="enable_manual_approvement_for_conciliations2">Desactivado</label>
                    </div>
                    <small class="form-text text-muted d-block">Esta opcion da control al encargado de almacen para definir que
                        proyectos estan aptos para pasar de as built al siguiente estado</small>
                </div>
                <div class="mb-3">
                    <label class="form-label d-block" for="exampleFormControlInput1">Denegar As Built si existen materiales pendientes de retiro en CRE</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" id="no_pending_materials_in_cre_for_as_built1" type="radio" name="no_pending_materials_in_cre_for_as_built" {{ old('no_pending_materials_in_cre_for_as_built', $statusManagementSettings->no_pending_materials_in_cre_for_as_built)== "1" ? 'checked' : '' }} value="1">
                        <label class="form-check-label" for="no_pending_materials_in_cre_for_as_built1">Activado</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" id="no_pending_materials_in_cre_for_as_built2" type="radio" name="no_pending_materials_in_cre_for_as_built" {{ old('no_pending_materials_in_cre_for_as_built', $statusManagementSettings->no_pending_materials_in_cre_for_as_built)== "0" ? 'checked' : '' }} value="0">
                        <label class="form-check-label" for="no_pending_materials_in_cre_for_as_built2">Desactivado</label>
                    </div>
                    <small class="form-text text-muted d-block">Con esta opcion habilitada, se niega el pase a As Built para todos los proyectos que tengan materiales pendientes de retiro en CRE</small>
                </div>
                <div class="col-12">
                    <button class="btn btn-primary" type="submit">Guardar configuraci&oacute;n</button>
                  </div>
            </form>
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
