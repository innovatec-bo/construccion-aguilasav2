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
            <div class="card mb-4">
                <div class="card-body">
                  <div class="row gy-3">
                    <div class="col-md-4 col-6">
                      <div class="d-flex align-items-center">
                        <div class="badge rounded bg-label-info me-4 p-2">
                            <i class="ti ti-folder ti-lg"></i></div>
                        <div class="card-info">
                          <h5 class="mb-0">{{$project->code_pro}}</h5>
                          <small>Proyecto</small>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4 col-6">
                      <div class="d-flex align-items-center">
                        <div class="badge rounded bg-label-danger me-4 p-2">
                            <i class="ti ti-trending-up ti-lg"></i>
                        </div>
                        <div class="card-info">
                          <h5 class="mb-0">{{number_format($project->productionAmount,2,'.',',')}}</h5>
                          <small>Producci&oacute;n (No incluye dise&ntilde;o)</small>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4 col-6">
                      <div class="d-flex align-items-center">
                        <div class="badge rounded bg-label-success me-4 p-2">
                            <i class="ti ti-activity ti-lg"></i>
                        </div>
                        <div class="card-info">
                          <h5 class="mb-0">{{$project->status->status_name_pst}}</h5>
                          <small>Estado</small>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <div class="row justify-content-around mb-4 row-gap-4">
                <div class="col-sm-6 col-md-4">
                    <div class="card card-border-shadow-primary h-100">
                        <div class="card-body">
                          <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-primary">
                                    <i class="ti ti-currency-dollar ti-28px"></i>
                                </span>
                            </div>
                            <h4 class="mb-0">{{number_format($project->currentBudget,2,'.',',')}}</h4>
                          </div>
                          <p class="mb-1">Importe</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="card card-border-shadow-primary h-100">
                        <div class="card-body">
                          <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-primary">
                                    <i class="ti ti-settings ti-28px"></i>
                                </span>
                            </div>
                            <h4 class="mb-0">{{$project->system->name}}</h4>
                          </div>
                          <p class="mb-1">Sistema</p>
                        </div>
                    </div>
                </div>
                <!-- /.col-->
                <div class="col-sm-6 col-md-4">
                    <div class="card card-border-shadow-primary h-100">
                        <div class="card-body">
                          <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-primary">
                                    <i class="ti ti-calendar ti-28px"></i>
                                </span>
                            </div>
                            <h6 class="mb-0">
                                @if ($project->entry_date_pro)
                                    {{$project->entry_date_pro->translatedFormat('D d M Y')}},
                                    {{$project->entry_date_pro->diffForHumans()}}
                                @endif    
                            </h6>
                          </div>
                          <p class="mb-1">Ingreso</p>
                        </div>
                    </div>
                </div>
                <!-- /.col-->
                <div class="col-sm-6 col-md-4">
                    <div class="card card-border-shadow-primary h-100">
                        <div class="card-body">
                          <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-primary">
                                    <i class="ti ti-user ti-28px"></i>
                                </span>
                            </div>
                            <h6 class="mb-0">{{$project->creFiscal->fullName}}</h6>
                          </div>
                          <p class="mb-1">Fiscal</p>
                        </div>
                    </div>
                </div>
                <!-- /.col-->
                <div class="col-sm-6 col-md-4">
                    <div class="card card-border-shadow-primary h-100">
                        <div class="card-body">
                          <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-primary">
                                    <i class="ti ti-map-pin ti-28px"></i>
                                </span>
                            </div>
                            <h6 class="mb-0">{{$project->address_pro}}</h6>
                          </div>
                          <p class="mb-1">Direcci&oacute;n</p>
                        </div>
                    </div>
                </div>
                <!-- /.col-->
                <div class="col-sm-6 col-md-4">
                    <div class="card card-border-shadow-primary h-100">
                        <div class="card-body">
                          <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-primary">
                                    <i class="ti ti-shape ti-28px"></i>
                                </span>
                            </div>
                            <h4 class="mb-0">{{$project->points_pro}}p/{{$project->distance_pro}}Km</h4>
                          </div>
                          <p class="mb-1">Area</p>
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