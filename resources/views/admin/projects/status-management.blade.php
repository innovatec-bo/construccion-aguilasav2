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
    </style>
    <div class="row">
        <div class="col-md-12 mb-4">
            <button class="btn btn-danger text-white btn-sm shadow-lg float-end fw-semibold" type="button" style="line-height: 0.94">
                {{-- <x-coreui-icon svgClass="icon" icon="cil-plus" /> --}}
                Avanzar al<br>siguiente estado
            </button>
            <nav class="breadcrumbs small shadow-lg d-none">
                <span href="javascript:void(0);" class="breadcrumbs__item">Proyecto creado</span>
                <span href="javascript:void(0);" class="breadcrumbs__item">Estqueado</span>
                <span href="javascript:void(0);" class="breadcrumbs__item">Dibujo</span>
                <span href="javascript:void(0);" class="breadcrumbs__item">Digitalizacion</span>
                <span href="javascript:void(0);" class="breadcrumbs__item is-active">Checkout</span>
            </nav>

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
                {{-- <div class="card-header">Descripci&oacute;n general</div> --}}
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                          <div class="border-start border-start-4 border-start-info px-3 mb-0"><small class="text-medium-emphasis text-truncate">Proyecto</small>
                            <div class="fs-5 fw-semibold">{{$project->code_pro}}</div>
                          </div>
                        </div>
                        <!-- /.col-->
                        <div class="col-4">
                          <div class="border-start border-start-4 border-start-danger px-3 mb-0"><small class="text-medium-emphasis text-truncate">Producci&oacute;n</small>
                            <div class="fs-5 fw-semibold">22.643</div>
                          </div>
                        </div><div class="col-4">
                          <div class="border-start border-start-4 border-start-danger px-3 mb-0"><small class="text-medium-emphasis text-truncate">Estado</small>
                            <div class="fs-5 fw-semibold">{{$project->status->status_name_pst}}</div>
                          </div>
                        </div>
                        <!-- /.col-->
                      </div>
                    {{-- <div class="row row-cols-1 justify-content-center row-cols-md-5 text-center mb-2">
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
                    </div> --}}
                    {{-- <div class="row justify-content-center">
                        <div id="chartDiv1" class="chartDiv" style="max-width: 770px;height: 560px"></div>
                    </div> --}}
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
                            <div class="fs-4 fw-semibold">12,813.63</div>
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
        {{-- <style>
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
        </style> --}}
        <div class="col-md-3">
            @livewire('admin.project-status-log-quick-view', ['project' => $project])
            {{-- <ul class="timeline small">
                <li class="timeline-item bg-white rounded ms-3 p-3 shadow">
                    <div class="timeline-arrow"></div>
                    <h2 class="h6 mb-0 fw-semibold">Enviado</h2><span class="small text-gray"><i
                            class="fa fa-clock-o mr-1"></i>21 de mazo del 2023, hace 20 dias</span>
                    <p class="text-small mt-1 font-weight-light"><strong>Responsable:</strong> Mario Aguilera</p>
                </li>
                <li class="timeline-item bg-white rounded ms-3 p-3 shadow">
                    <div class="timeline-arrow"></div>
                    <h2 class="h6 mb-0 fw-semibold">Enviado</h2><span class="small text-gray"><i
                            class="fa fa-clock-o mr-1"></i>21 de mazo del 2023, hace 20 dias</span>
                    <p class="text-small mt-1 font-weight-light"><strong>Responsable:</strong> Mario Aguilera</p>
                </li>
                <li class="timeline-item bg-white rounded ms-3 p-3 shadow">
                    <div class="timeline-arrow"></div>
                    <h2 class="h6 mb-0 fw-semibold">Enviado</h2><span class="small text-gray"><i
                            class="fa fa-clock-o mr-1"></i>21 de mazo del 2023, hace 20 dias</span>
                    <p class="text-small mt-1 font-weight-light"><strong>Responsable:</strong> Mario Aguilera</p>
                </li>
                <li class="timeline-item bg-white rounded ms-3 p-3 shadow">
                    <div class="timeline-arrow"></div>
                    <h2 class="h6 mb-0 fw-semibold">Enviado</h2><span class="small text-gray"><i
                            class="fa fa-clock-o mr-1"></i>21 de mazo del 2023, hace 20 dias</span>
                    <p class="text-small mt-1 font-weight-light"><strong>Responsable:</strong> Mario Aguilera</p>
                </li>
            </ul> --}}
        </div>
    </div>

@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    <style>
        .chartDiv {
            margin: 8px auto;
            padding: 15px;
            border-radius: 10px;
        }
    </style>

@stop

@section('js')
    {{-- <script> console.log('Hi!'); </script> --}}
    <script type="text/javascript" src="https://code.jscharting.com/latest/jscharting.js"></script>
    <script>
        // JS 
        var selectedPoint;
        var highlightColor = '#5C6BC0',
            mutedHighlightColor = '#9FA8DA',
            mutedFill = '#f3f4fa',
            selectedFill = '#E8EAF6',
            normalFill = 'white';

        var points = [
            //Level 1
            {
                x: 'Proyecto creado',
                id: 'project_has_been_created',
                attributes: {
                    role: '',
                    photo: ''
                }
            },
            //Level 2
            {
                x: 'Estaqueado',
                id: 'stakes',
                parent: 'project_has_been_created',
                attributes: {
                    role: '',
                    photo: ''
                }
            },
            //Level 3 
            {
                x: 'Digitalizacion',
                id: 'digitization',
                parent: 'stakes',
                attributes: {
                    role: '',
                    photo: ''
                }
            },
            {
                x: 'Dibujo',
                id: 'drawing',
                parent: 'stakes',
                attributes: {
                    role: '',
                    photo: ''
                }
            },
            {
                x: 'No factible',
                id: 'returned',
                parent: 'stakes',
                attributes: {
                    role: '',
                    photo: ''
                }
            },
            //Level 4
            {
                x: 'Dibujo',
                id: 'drawing1',
                parent: 'digitization',
                attributes: {
                    role: '',
                    photo: ''
                }
            },
            {
                x: 'Digitalizacion',
                id: 'digitization1',
                parent: 'drawing',
                attributes: {
                    role: '',
                    photo: ''
                }
            },
            {
                x: 'Cancelado',
                id: 'canceled',
                parent: 'returned',
                attributes: {
                    role: '',
                    photo: ''
                }
            },
            //Level 5
            {
                x: 'Cronograma',
                id: 'Schedule',
                parent: 'drawing1',
                attributes: {
                    role: '',
                    photo: ''
                }
            },
            {
                x: 'Cronograma',
                id: 'Schedule1',
                parent: 'digitization1',
                attributes: {
                    role: '',
                    photo: ''
                }
            },
        ];

        var chart = JSC.chart('chartDiv1', {
            debug: true,
            type: 'organizational',
            defaultTooltip_enabled: false,

            /* These options will apply to all annotations including point nodes. */
            defaultAnnotation: {
                padding: [5, 10],
                margin: 6
            },
            annotations: [{
                position: 'bottom',
                label_text: 'Click on a node to select all nodes up the tree or click again to deselect.'
            }],

            defaultSeries: {
                color: normalFill,
                /* Point selection is disabled because it is managed manually with point click events. */
                pointSelection: false
            },
            defaultPoint: {
                focusGlow: false,
                connectorLine: {
                    color: '#e0e0e0',
                    radius: [10, 3]
                },
                label: {
                    text: '%photo%name<br><span style="color:#9E9E9E">%role</span>',
                    style_color: 'black'
                },
                outline: {
                    color: '#e0e0e0',
                    width: 1
                },
                annotation: {
                    syncHeight_with: 'level'
                },
                states: {
                    mute: {
                        opacity: 0.8,
                        outline: {
                            color: mutedHighlightColor,
                            opacity: 0.9,
                            width: 2
                        }
                    },
                    select: {
                        enabled: true,
                        outline: {
                            color: highlightColor,
                            width: 2
                        },
                        color: selectedFill
                    },
                    hover: {
                        outline: {
                            color: mutedHighlightColor,
                            width: 2
                        },
                        color: mutedFill
                    }
                },
                events: {
                    click: pointClick,
                    mouseOver: pointMouseOver,
                    mouseOut: pointMouseOut
                }
            },
            series: [{
                points: points
            }]
        });

        /** 
         * Event Handlers 
         */

        function pointClick() {
            var point = this,
                chart = point.chart;
            resetStyles(chart);
            if (point.id === selectedPoint) {
                selectedPoint = undefined;
                return;
            }
            selectedPoint = point.id;
            styleSelectedPoint(chart);
        }

        function pointMouseOver() {
            var point = this,
                chart = point.chart;
            chart.connectors([point.id, 'up'], {
                color: mutedHighlightColor,
                width: 2
            });
            chart
                .series()
                .points([point.id, 'up'])
                .options({
                    muted: true
                });
        }

        function pointMouseOut() {
            var point = this,
                chart = point.chart;
            // Reset point and line styling. 
            resetStyles(chart);
            // Style clicked points 
            styleSelectedPoint(chart);
            return false;
        }

        /** 
         * Styling helper functions 
         */

        function styleSelectedPoint(chart) {
            if (selectedPoint) {
                chart.connectors([selectedPoint, 'up'], {
                    color: highlightColor,
                    width: 2
                });
                chart
                    .series()
                    .points([selectedPoint, 'up'])
                    .options({
                        selected: true,
                        muted: false
                    });
            }
        }

        /** 
         * Clears connectors and point states. 
         * @param chart Chart object 
         */
        function resetStyles(chart) {
            chart.connectors();
            chart
                .series()
                .points()
                .options({
                    selected: false,
                    muted: false
                });
        }

        function getImgText(name) {
            return (
                '<img width=50 height=50 align=center margin_bottom=4 margin_top=4 src=' +
                name +
                '><br>'
            );
        }
    </script>
@stop
