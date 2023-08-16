@extends('layouts.dashboard-layout')

@section('title', 'Administracion de estados')

@section('breadcrumb')
    {{ Breadcrumbs::render('admin.projects.status-management', $project) }}
@stop

@section('content')
    <style>
        .breadcrumbs {
            border: 1px solid #cbd2d9;
            border-radius: 0.3rem;
            display: inline-flex;
            overflow: hidden;
        }

        .breadcrumbs__item {
            background: #fff;
            color: #333;
            outline: none;
            padding: 0.75em 0.75em 0.75em 1.25em;
            position: relative;
            text-decoration: none;
            transition: background 0.2s linear;
        }

        .breadcrumbs__item:focus:after,
        .breadcrumbs__item:focus,
        .breadcrumbs__item.is-active:focus {
            background: #323f4a;
            color: #fff;
        }

        .breadcrumbs__item:after,
        .breadcrumbs__item:before {
            background: white;
            bottom: 0;
            clip-path: polygon(50% 50%, -50% -50%, 0 100%);
            content: "";
            left: 100%;
            position: absolute;
            top: 0;
            transition: background 0.2s linear;
            width: 1em;
            z-index: 1;
        }

        .breadcrumbs__item:before {
            background: #cbd2d9;
            margin-left: 1px;
        }

        .breadcrumbs__item:last-child {
            border-right: none;
        }

        .breadcrumbs__item.is-active {
            background: #edf1f5;
        }
        /* Some styles to make the page look a little nicer */
        .list-group-timeline .list-group-item::after {
            content: "";
            position: absolute;
            top: 15px;
            left: 8px;
            width: 10px;
            height: 10px;
            margin-top: 0.425rem;
            margin-left: -0.5rem;
            border: 2px solid #cbcbcf;
            background: #fff;
            border-radius: 0.5rem;
        }

        .list-group-timeline .list-group-item::before {
            content: "";
            position: absolute;
            top: 0;
            left: 4px;
            height: 100%;
            border-left: 2px solid #cbcbcf;
        }
    </style>
    <div class="row">
        <div class="col-md-12 mb-4">
            @if (count($nextStatusList) > 1)
                <div class="dropdown me-3 d-inline-flex">
                    <button class="btn btn-primary dropdown-toggle" id="dropdownMenuButton" type="button" data-coreui-toggle="dropdown" aria-expanded="false">Mover a..</button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" style="">
                        @foreach ($nextStatusList as $row)
                            <li><a class="dropdown-item" href="javascript:void(0);" onclick="Livewire.emit('showModal', 'admin.status-form',{{$project->id_pro}},{{$row->nextStatus->id_pst}});">{{$row->nextStatus->status_name_pst}}</a></li>
                        @endforeach
                    </ul>
                </div>
            @elseif(count($nextStatusList) == 1)
                <button class="btn btn-primary me-3"  onclick="Livewire.emit('showModal', 'admin.status-form',{{$project->id_pro}},{{$nextStatusList[0]->nextStatus->id_pst}});" type="button">Mover a {{$nextStatusList[0]->nextStatus->status_name_pst}}</button>
            @else
                <button class="btn btn-primary me-3 disabled" disabled role="button">Mover a ..</button>
            @endif
            <button class="btn btn-danger text-white" type="button">Registrar incidencia</button>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card mb-4 shadow">
                {{-- <div class="card-header">Descripci&oacute;n general</div> --}}
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                          <div class="border-start border-start-4 border-start-info px-3 mb-0 fw-semibold"><small class="text-medium-emphasis text-truncate">Proyecto</small>
                            <div class="fs-5 fw-semibold">{{$project->code_pro}}</div>
                          </div>
                        </div>
                        <!-- /.col-->
                        <div class="col-4">
                          <div class="border-start border-start-4 border-start-danger px-3 mb-0">
                            <small class="text-medium-emphasis text-truncate fw-semibold">Producci&oacute;n (No incluye dise&ntilde;o)</small>
                            <div class="fs-5 fw-semibold">{{number_format($project->productionAmount,2,'.',',')}}</div>
                          </div>
                        </div><div class="col-4">
                          <div class="border-start border-start-4 border-start-danger px-3 mb-0 fw-semibold"><small class="text-medium-emphasis text-truncate">Estado</small>
                            <div class="fs-5 fw-semibold">{{$project->status->status_name_pst}}</div>
                          </div>
                        </div>
                        <!-- /.col-->
                      </div>
                </div>
            </div>
            <div class="row justify-content-around mb-4">
                <div class="col-sm-6 col-md-4">
                    <div class="card shadow mb-3">
                        <div class="card-body">
                            <div class="text-medium-emphasis text-end mb-4">
                                <svg class="icon icon-xxl">
                                    <x-coreui-icon svgClass="nav-icon" icon="cil-dollar" />
                                </svg>
                            </div>
                            <div class="fs-4 fw-semibold">{{number_format($project->currentBudget,2,'.',',')}}</div>
                            <small class="text-medium-emphasis text-uppercase fw-semibold">Importe</small>
                        </div>
        
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="card shadow mb-3">
                        <div class="card-body">
                            <div class="text-medium-emphasis text-end mb-4">
                                <svg class="icon icon-xxl">
                                    <x-coreui-icon svgClass="nav-icon" icon="cil-cog" />
                                </svg>
                            </div>
                            <div class="fs-4 fw-semibold">{{$project->system->name}}</div><small
                                class="text-medium-emphasis text-uppercase fw-semibold">Sistema</small>
                        </div>
                    </div>
                </div>
                <!-- /.col-->
                <div class="col-sm-6 col-md-4">
                    <div class="card shadow mb-3">
                        <div class="card-body">
                            <div class="text-medium-emphasis text-end mb-4">
                                <svg class="icon icon-xxl">
                                    <x-coreui-icon svgClass="nav-icon" icon="cil-calendar" />
                                </svg>
                            </div>
                            <div class="fs-6 fw-semibold">
                                @if ($project->entry_date_pro)
                                    {{$project->entry_date_pro->translatedFormat('D d M Y')}},
                                    {{$project->entry_date_pro->diffForHumans()}}
                                @endif
                            </div><small
                                class="text-medium-emphasis text-uppercase fw-semibold">Ingreso</small>
                        </div>
                    </div>
                </div>
                <!-- /.col-->
                <div class="col-sm-6 col-md-4">
                    <div class="card shadow mb-3">
                        <div class="card-body">
                            <div class="text-medium-emphasis text-end mb-4">
                                <svg class="icon icon-xxl">
                                    <x-coreui-icon svgClass="nav-icon" icon="cil-user" />
                                </svg>
                            </div>
                            <div class="fs-4 fw-semibold">{{$project->creFiscal->fullName}}</div><small
                                class="text-medium-emphasis text-uppercase fw-semibold">Fiscal</small>
                        </div>
                    </div>
                </div>
                <!-- /.col-->
                <div class="col-sm-6 col-md-4">
                    <div class="card shadow mb-3">
                        <div class="card-body">
                            <div class="text-medium-emphasis text-end mb-4">
                                <svg class="icon icon-xxl">
                                    <x-coreui-icon svgClass="nav-icon" icon="cil-location-pin" />
                                </svg>
                            </div>
                            <div class="fs-5 fw-semibold">{{$project->address_pro}}</div><small
                                class="text-medium-emphasis text-uppercase fw-semibold">Direcci&oacute;n</small>
                        </div>
                    </div>
                </div>
                <!-- /.col-->
                <div class="col-sm-6 col-md-4">
                    <div class="card shadow mb-3">
                        <div class="card-body">
                            <div class="text-medium-emphasis text-end mb-4">
                                <svg class="icon icon-xxl">
                                    <x-coreui-icon svgClass="nav-icon" icon="cil-text-shapes" />
                                </svg>
                            </div>
                            <div class="fs-4 fw-semibold">{{$project->points_pro}}p/{{$project->distance_pro}}Km</div>
                            <small class="text-medium-emphasis text-uppercase fw-semibold">Area</small>
                        </div>
                    </div>
                </div>
                <!-- /.col-->
            </div>
        </div>
        <div class="col-md-3">
            @livewire('admin.project-status-log-quick-view', ['project' => $project])
        </div>
    </div>

@stop

@section('css')
    <link rel="stylesheet" href="{{asset('js/bootstrap-datepicker-1.9.0/css/bootstrap-datepicker3.css')}}">
@stop

@section('js')
    <script src="{{asset('js/bootstrap-datepicker-1.9.0/js/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('js/bootstrap-datepicker-1.9.0/locales/bootstrap-datepicker.es.min.js')}}"></script>
@stop