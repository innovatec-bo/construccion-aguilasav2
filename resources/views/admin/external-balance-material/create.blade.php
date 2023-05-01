@extends('layouts.dashboard-layout')

@section('title', 'Cargar balance externo de materiales')

@section('breadcrumb')
    {{ Breadcrumbs::render('admin.external-balance-material.create') }}
@stop

@section('content')
    {{-- @livewire('admin.user-create') --}}

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-lg">
                {{-- <div class="card-header">

                </div> --}}
                <div class="card-body">
                    {{-- <h5 class="card-title">Special title treatment</h5> --}}
                    <p class="card-text">El balance externo de materiales contiene un resumen de los materiales que ya se han
                        devuelto y que aun deben devolverse a CRE</p>
                    <p class="card-text">La importacion del archivo excel consta de 3 pasos:</p>
                    <ol>
                        <li>Cuando se selecciona el archivo, este es leido por el sistema y arroja un breve detalle, sobre
                            el nombre y el peso del mismo</li>
                        <li>Cuando el achivo es seleccionado, aparece un boton llamado "Pre cargar", que nos da un detalle
                            mas amplio esta ves acerca de la informacion contenida en el archivo</li>
                        <li>Si la informacion observada con el boton "Pre cargar" es satisfactoria, entonces procedemos a
                            cargar el archivo. Nota: debido a que el archivo es bastante pesado, no se almacena en el
                            servidor.</li>
                    </ol>
                    <p class="text-center">
                        <a class="btn btn-primary" href="#">Cargar Balance externo de materiales</a>
                    </p>
                    <div class="table-responsive">
                        <table class="table border mb-0">
                            <tbody>
                                <tr class="align-middle">
                                    <td>
                                        <div>Yiorgos Avraamu</div>
                                        <div class="small text-medium-emphasis"><span>New</span> | Registered: Jan 1, 2020
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <svg class="icon icon-xl">
                                            <use xlink:href="vendors/@coreui/icons/svg/flag.svg#cif-us"></use>
                                        </svg>
                                    </td>
                                    <td>
                                        <div class="clearfix">
                                            <div class="float-start">
                                                <div class="fw-semibold">50%</div>
                                            </div>
                                            <div class="float-end">
                                                <small class="text-medium-emphasis">Jun 11, 2020 - Jul 10, 2020</small>
                                            </div>
                                        </div>
                                        <div class="progress progress-thin">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 50%"
                                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <svg class="icon icon-xl">
                                            <use xlink:href="vendors/@coreui/icons/svg/brand.svg#cib-cc-mastercard"></use>
                                        </svg>
                                    </td>
                                    <td>
                                        <a class="btn btn-danger" href="#">Cancelar</a>
                                        <a class="btn btn-primary" href="#">Pre cargar</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row row-cols-1 row-cols-md-5 text-center">
                        <div class="col mb-sm-2 mb-0">
                          <div class="text-medium-emphasis">Proyectos</div>
                          <div class="fw-semibold">29.703 Users (40%)</div>
                          {{-- <div class="progress progress-thin mt-2">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                          </div> --}}
                        </div>
                        <div class="col mb-sm-2 mb-0">
                          <div class="text-medium-emphasis">Ingresos(221)</div>
                          <div class="fw-semibold">24.093 Users (20%)</div>
                        </div>
                        <div class="col mb-sm-2 mb-0">
                          <div class="text-medium-emphasis">Egresos(222)</div>
                          <div class="fw-semibold">78.706 Views (60%)</div>
                        </div>
                        <div class="col mb-sm-2 mb-0">
                          <div class="text-medium-emphasis">Variedad de Materiales</div>
                          <div class="fw-semibold">22.123 Users (80%)</div>
                        </div>
                        <div class="col mb-sm-2 mb-0">
                          <div class="text-medium-emphasis">Total registros</div>
                          <div class="fw-semibold">40.15%</div>
                        </div>
                      </div>
                </div>
                {{-- <div class="card-body p-0"> --}}
                    {{-- <form action="{{ route('admin.external-balance-material.store') }}" method="post" class="dropzone"
                        id="my-awesome-dropzone">
                        @method('post')
                        @csrf
                    </form> --}}
                {{-- </div> --}}
            </div>
        </div>
    </div>

@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
@stop

@section('js')
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    {{-- <script> console.log('Hi!'); </script> --}}
@stop
