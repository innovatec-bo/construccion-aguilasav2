@extends('layouts.dashboard-layout')

@section('title', 'Administracion de estados')

@section('breadcrumb')
    {{ Breadcrumbs::render('admin.projects.status-management') }}
@stop

@section('content')
    <div class="row row-cols-1 justify-content-center row-cols-md-5 text-center mb-2">
        <div class="col mb-sm-2 mb-0">
            <div class="text-medium-emphasis">Proyecto</div>
            <div class="fw-semibold">RA.23.0098</div>
        </div>
        <div class="col mb-sm-2 mb-0">
            <div class="text-medium-emphasis">Producci&oacute;n</div>
            <div class="fw-semibold">24.093 Users (20%)</div>
        </div>
        <div class="col mb-sm-2 mb-0">
            <div class="text-medium-emphasis">Estado</div>
            <div class="fw-semibold">78.706 Views (60%)</div>
        </div>
    </div>
    <div class="row justify-content-around mb-4">
        <div class="col-sm-6 col-md-2">
            <div class="card shadow">
                <div class="card-body">
                    <div class="text-medium-emphasis text-end mb-3">
                        <svg class="icon icon-xxl">
                            <x-coreui-icon svgClass="nav-icon" icon="cil-dollar" />
                        </svg>
                    </div>
                    <div class="fs-4 fw-semibold">12,813.63</div>
                    <small class="text-medium-emphasis text-uppercase fw-semibold">Importe</small>
                    <div class="progress progress-thin mt-0 mb-0">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 25%" aria-valuenow="25"
                            aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-sm-6 col-md-2">
            <div class="card shadow">
                <div class="card-body">
                    <div class="text-medium-emphasis text-end mb-4">
                        <svg class="icon icon-xxl">
                            <x-coreui-icon svgClass="nav-icon" icon="cil-cog" />
                        </svg>
                    </div>
                    <div class="fs-4 fw-semibold">87.500</div><small
                        class="text-medium-emphasis text-uppercase fw-semibold">Sistema</small>
                </div>
            </div>
        </div>
        <!-- /.col-->
        <div class="col-sm-6 col-md-2">
            <div class="card shadow">
                <div class="card-body">
                    <div class="text-medium-emphasis text-end mb-4">
                        <svg class="icon icon-xxl">
                            <x-coreui-icon svgClass="nav-icon" icon="cil-calendar" />
                        </svg>
                    </div>
                    <div class="fs-4 fw-semibold">385</div><small
                        class="text-medium-emphasis text-uppercase fw-semibold">Ingreso</small>
                </div>
            </div>
        </div>
        <!-- /.col-->
        <div class="col-sm-6 col-md-2">
            <div class="card shadow">
                <div class="card-body">
                    <div class="text-medium-emphasis text-end mb-4">
                        <svg class="icon icon-xxl">
                            <x-coreui-icon svgClass="nav-icon" icon="cil-user" />
                        </svg>
                    </div>
                    <div class="fs-4 fw-semibold">1238</div><small
                        class="text-medium-emphasis text-uppercase fw-semibold">Fiscal</small>
                </div>
            </div>
        </div>
        <!-- /.col-->
        <div class="col-sm-6 col-md-2">
            <div class="card shadow">
                <div class="card-body">
                    <div class="text-medium-emphasis text-end mb-4">
                        <svg class="icon icon-xxl">
                            <x-coreui-icon svgClass="nav-icon" icon="cil-location-pin" />
                        </svg>
                    </div>
                    <div class="fs-4 fw-semibold">28%</div><small
                        class="text-medium-emphasis text-uppercase fw-semibold">Direcci&oacute;n</small>
                </div>
            </div>
        </div>
        <!-- /.col-->
        <div class="col-sm-6 col-md-2">
            <div class="card shadow">
                <div class="card-body">
                    <div class="text-medium-emphasis text-end mb-4">
                        <svg class="icon icon-xxl">
                            <x-coreui-icon svgClass="nav-icon" icon="cil-text-shapes" />
                        </svg>
                    </div>
                    <div class="fs-4 fw-semibold">5:34:11</div>
                    <small class="text-medium-emphasis text-uppercase fw-semibold">Area</small>
                </div>
            </div>
        </div>
        <!-- /.col-->
    </div>
    <div class="row">
        <div class="col-md-12">

        </div>
    </div>
    <div class="row justify-content-center">
        <style>
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
        <div class="col-md-9">
            <div class="card mb-4 shadow">
                <div class="card-header">Traffic &amp; Sales</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-6">
                                    <div class="border-start border-start-4 border-start-info px-3 mb-3"><small
                                            class="text-medium-emphasis">New Clients</small>
                                        <div class="fs-5 fw-semibold">9.123</div>
                                    </div>
                                </div>
                                <!-- /.col-->
                                <div class="col-6">
                                    <div class="border-start border-start-4 border-start-danger px-3 mb-3"><small
                                            class="text-medium-emphasis">Recuring Clients</small>
                                        <div class="fs-5 fw-semibold">22.643</div>
                                    </div>
                                </div>
                                <!-- /.col-->
                            </div>
                            <!-- /.row-->
                            <hr class="mt-0">
                            <div class="progress-group mb-4">
                                <div class="progress-group-prepend"><span class="text-medium-emphasis small">Monday</span>
                                </div>
                                <div class="progress-group-bars">
                                    <div class="progress progress-thin">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 34%"
                                            aria-valuenow="34" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="progress progress-thin">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 78%"
                                            aria-valuenow="78" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="progress-group mb-4">
                                <div class="progress-group-prepend"><span
                                        class="text-medium-emphasis small">Tuesday</span></div>
                                <div class="progress-group-bars">
                                    <div class="progress progress-thin">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 56%"
                                            aria-valuenow="56" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="progress progress-thin">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 94%"
                                            aria-valuenow="94" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="progress-group mb-4">
                                <div class="progress-group-prepend"><span
                                        class="text-medium-emphasis small">Wednesday</span></div>
                                <div class="progress-group-bars">
                                    <div class="progress progress-thin">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 12%"
                                            aria-valuenow="12" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="progress progress-thin">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 67%"
                                            aria-valuenow="67" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="progress-group mb-4">
                                <div class="progress-group-prepend"><span
                                        class="text-medium-emphasis small">Thursday</span></div>
                                <div class="progress-group-bars">
                                    <div class="progress progress-thin">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 43%"
                                            aria-valuenow="43" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="progress progress-thin">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 91%"
                                            aria-valuenow="91" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="progress-group mb-4">
                                <div class="progress-group-prepend"><span class="text-medium-emphasis small">Friday</span>
                                </div>
                                <div class="progress-group-bars">
                                    <div class="progress progress-thin">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 22%"
                                            aria-valuenow="22" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="progress progress-thin">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 73%"
                                            aria-valuenow="73" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="progress-group mb-4">
                                <div class="progress-group-prepend"><span
                                        class="text-medium-emphasis small">Saturday</span></div>
                                <div class="progress-group-bars">
                                    <div class="progress progress-thin">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 53%"
                                            aria-valuenow="53" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="progress progress-thin">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 82%"
                                            aria-valuenow="82" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="progress-group mb-4">
                                <div class="progress-group-prepend"><span class="text-medium-emphasis small">Sunday</span>
                                </div>
                                <div class="progress-group-bars">
                                    <div class="progress progress-thin">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 9%"
                                            aria-valuenow="9" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="progress progress-thin">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 69%"
                                            aria-valuenow="69" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.col-->
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-6">
                                    <div class="border-start border-start-4 border-start-warning px-3 mb-3"><small
                                            class="text-medium-emphasis">Pageviews</small>
                                        <div class="fs-5 fw-semibold">78.623</div>
                                    </div>
                                </div>
                                <!-- /.col-->
                                <div class="col-6">
                                    <div class="border-start border-start-4 border-start-success px-3 mb-3"><small
                                            class="text-medium-emphasis">Organic</small>
                                        <div class="fs-5 fw-semibold">49.123</div>
                                    </div>
                                </div>
                                <!-- /.col-->
                            </div>
                            <!-- /.row-->
                            <hr class="mt-0">
                            <div class="progress-group">
                                <div class="progress-group-header">
                                    <svg class="icon icon-lg me-2">
                                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-user"></use>
                                    </svg>
                                    <div>Male</div>
                                    <div class="ms-auto fw-semibold">43%</div>
                                </div>
                                <div class="progress-group-bars">
                                    <div class="progress progress-thin">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 43%"
                                            aria-valuenow="43" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="progress-group mb-5">
                                <div class="progress-group-header">
                                    <svg class="icon icon-lg me-2">
                                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-user-female"></use>
                                    </svg>
                                    <div>Female</div>
                                    <div class="ms-auto fw-semibold">37%</div>
                                </div>
                                <div class="progress-group-bars">
                                    <div class="progress progress-thin">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 43%"
                                            aria-valuenow="43" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="progress-group">
                                <div class="progress-group-header">
                                    <svg class="icon icon-lg me-2">
                                        <use xlink:href="vendors/@coreui/icons/svg/brand.svg#cib-google"></use>
                                    </svg>
                                    <div>Organic Search</div>
                                    <div class="ms-auto fw-semibold me-2">191.235</div>
                                    <div class="text-medium-emphasis small">(56%)</div>
                                </div>
                                <div class="progress-group-bars">
                                    <div class="progress progress-thin">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 56%"
                                            aria-valuenow="56" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="progress-group">
                                <div class="progress-group-header">
                                    <svg class="icon icon-lg me-2">
                                        <use xlink:href="vendors/@coreui/icons/svg/brand.svg#cib-facebook-f"></use>
                                    </svg>
                                    <div>Facebook</div>
                                    <div class="ms-auto fw-semibold me-2">51.223</div>
                                    <div class="text-medium-emphasis small">(15%)</div>
                                </div>
                                <div class="progress-group-bars">
                                    <div class="progress progress-thin">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 15%"
                                            aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="progress-group">
                                <div class="progress-group-header">
                                    <svg class="icon icon-lg me-2">
                                        <use xlink:href="vendors/@coreui/icons/svg/brand.svg#cib-twitter"></use>
                                    </svg>
                                    <div>Twitter</div>
                                    <div class="ms-auto fw-semibold me-2">37.564</div>
                                    <div class="text-medium-emphasis small">(11%)</div>
                                </div>
                                <div class="progress-group-bars">
                                    <div class="progress progress-thin">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 11%"
                                            aria-valuenow="11" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="progress-group">
                                <div class="progress-group-header">
                                    <svg class="icon icon-lg me-2">
                                        <use xlink:href="vendors/@coreui/icons/svg/brand.svg#cib-linkedin"></use>
                                    </svg>
                                    <div>LinkedIn</div>
                                    <div class="ms-auto fw-semibold me-2">27.319</div>
                                    <div class="text-medium-emphasis small">(8%)</div>
                                </div>
                                <div class="progress-group-bars">
                                    <div class="progress progress-thin">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 8%"
                                            aria-valuenow="8" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.col-->
                    </div>
                </div>
            </div>
        </div>
        <style>
            ul.timeline {
                list-style-type: none;
                position: relative;
                padding-left: 1.5rem;
            }
            li.timeline-item {
                margin: 20px 0;
            }
            .timeline-arrow {
                border-top: 0.5rem solid transparent;
                border-right: 0.5rem solid #fff;
                border-bottom: 0.5rem solid transparent;
                display: block;
                position: absolute;
                left: 2rem;
            }
            ul.timeline:before {
                content: ' ';
                background: #cbcbcf;
                display: inline-block;
                position: absolute;
                left: 16px;
                width: 4px;
                height: 100%;
                z-index: 400;
                border-radius: 1rem;
            }
            li.timeline-item::before {
                content: ' ';
                background: #cbcbcf;
                display: inline-block;
                position: absolute;
                border-radius: 50%;
                border: 3px solid #fff;
                left: 11px;
                width: 14px;
                height: 14px;
                z-index: 400;
                box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
            }
        </style>
        <div class="col-md-3">
            <ul class="timeline small">
                <li class="timeline-item bg-white rounded ms-3 p-3 shadow">
                    <div class="timeline-arrow"></div>
                    <h2 class="h6 mb-0 fw-semibold">Enviado</h2><span class="small text-gray"><i class="fa fa-clock-o mr-1"></i>21 de mazo del 2023, hace 20 dias</span>
                    <p class="text-small mt-1 font-weight-light"><strong>Responsable:</strong> Mario Aguilera</p>
                </li>
                <li class="timeline-item bg-white rounded ms-3 p-3 shadow">
                    <div class="timeline-arrow"></div>
                    <h2 class="h6 mb-0 fw-semibold">Enviado</h2><span class="small text-gray"><i class="fa fa-clock-o mr-1"></i>21 de mazo del 2023, hace 20 dias</span>
                    <p class="text-small mt-1 font-weight-light"><strong>Responsable:</strong> Mario Aguilera</p>
                </li>
                <li class="timeline-item bg-white rounded ms-3 p-3 shadow">
                    <div class="timeline-arrow"></div>
                    <h2 class="h6 mb-0 fw-semibold">Enviado</h2><span class="small text-gray"><i class="fa fa-clock-o mr-1"></i>21 de mazo del 2023, hace 20 dias</span>
                    <p class="text-small mt-1 font-weight-light"><strong>Responsable:</strong> Mario Aguilera</p>
                </li>
                <li class="timeline-item bg-white rounded ms-3 p-3 shadow">
                    <div class="timeline-arrow"></div>
                    <h2 class="h6 mb-0 fw-semibold">Enviado</h2><span class="small text-gray"><i class="fa fa-clock-o mr-1"></i>21 de mazo del 2023, hace 20 dias</span>
                    <p class="text-small mt-1 font-weight-light"><strong>Responsable:</strong> Mario Aguilera</p>
                </li>
            </ul>
        </div>
        <div class="col-md-3 d-none">
            <div class="card notification-card border-0 shadow">
                <div class="card-header d-flex align-items-center">
                    <h2 class="fs-5 fw-bold mb-0">Actividad</h2>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush list-group-timeline">
                        <div class="list-group-item border-0">
                            <div class="row ps-lg-1">
                                <div class="col ms-n2 mb-3">
                                    <h3 class="fs-6 fw-bold mb-1">You sold an item</h3>
                                    <p class="mb-1">Bonnie Green just purchased "Volt - Admin Dashboard"!</p>
                                    <div class="d-flex align-items-center"><svg class="icon icon-xxs text-gray-400 me-1"
                                            fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                clip-rule="evenodd"></path>
                                        </svg> <span class="small">1 minute ago</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item border-0">
                            <div class="row ps-lg-1">
                                <div class="col ms-n2 mb-3">
                                    <h3 class="fs-6 fw-bold mb-1">New message</h3>
                                    <p class="mb-1">Let's meet at Starbucks at 11:30. Wdyt?</p>
                                    <div class="d-flex align-items-center"><svg class="icon icon-xxs text-gray-400 me-1"
                                            fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                clip-rule="evenodd"></path>
                                        </svg> <span class="small">8 minutes ago</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item border-0">
                            <div class="row ps-lg-1">
                                <div class="col ms-n2 mb-3">
                                    <h3 class="fs-6 fw-bold mb-1">Product issue</h3>
                                    <p class="mb-0">A new issue has been reported for Pixel Pro.</p>
                                    <div class="d-flex align-items-center"><svg class="icon icon-xxs text-gray-400 me-1"
                                            fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                clip-rule="evenodd"></path>
                                        </svg> <span class="small">10 minutes ago</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item border-0">
                            <div class="row ps-lg-1">
                                <div class="col ms-n2 mb-3">
                                    <h3 class="fs-6 fw-bold mb-1">Product update</h3>
                                    <p class="mb-0">Spaces - Listings Template has been updated</p>
                                    <div class="d-flex align-items-center"><svg class="icon icon-xxs text-gray-400 me-1"
                                            fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                clip-rule="evenodd"></path>
                                        </svg> <span class="small">4 hours ago</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item border-0">
                            <div class="row ps-lg-1">
                                <div class="col ms-n2">
                                    <h3 class="fs-6 fw-bold mb-1">Product update</h3>
                                    <p class="mb-0">Volt - Admin Dashboard has been updated</p>
                                    <div class="d-flex align-items-center"><svg class="icon icon-xxs text-gray-400 me-1"
                                            fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                clip-rule="evenodd"></path>
                                        </svg> <span class="small">8 hours ago</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    {{-- <script> console.log('Hi!'); </script> --}}
@stop
