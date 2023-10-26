@extends('layouts.dashboard-layout')

@section('title', 'Detalle de mano de obra: '.$laborDetail->project->code_pro)

@section('breadcrumb')
    {{ Breadcrumbs::render('admin.labor-details.show', $laborDetail) }}
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12 mb-2 text-end">
            <a class="btn btn-sm btn-primary d-print-none float-right mx-1" href="{{url()->previous()}}">Volver</a>
            @can('admin.labor-details.export')
                <div class="btn-group btn-group-sm" style="">
                    <a href="{{route('admin.labor-details.export', $laborDetail->id_lad)}}" class="btn btn-primary d-print-none"><i class="far fa-file-excel"></i> Exportar</a>
                    <a class="btn btn-info d-print-none float-right ml-2 text-white" href="javascript:void(0)" id="btn-print"><i class="fa fa-print fa-fw"></i>Imprimir</a>
                </div>
            @endcan
        </div>
        <div class="col-md-12 mb-3">
            <div class="card shadow-lg" id="print-area">
                <div class="card-header">
                    <h3 class="text-center d-print-none">Detalle de mano de obra: {{$laborDetail->project->code_pro}}</h3>
                    <h3 class="text-center d-none d-print-block">Detalle de mano de obra: {{$laborDetail->project->code_pro}}</h3>
                    <h4 class="text-center mb-4 d-none d-print-block">{!! ucfirst($laborDetail->environment['label']) !!}</h4>
                </div>

                <div class="card-body p-0">
                    <table class="table table-bordered table-sm table-hover table-striped small mb-0">
                        <thead>
                            <tr>
                                <th>Estructura</th>
                                <th>Actividad</th>
                                <th>Ejecucion</th>
                                <th>Cantidad</th>
                                <th>Precio<br>Unitario</th>
                                <th>Es<br>adicional?</th>
                                <th>Cant.<br>Materiales</th>
                                <th class="d-print-none">Personalizar<br>materiales</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($laborDetail->laborCosts as $laborCost)
                                <tr>
                                    <td>
                                        <span class="text-info">{{$laborCost->buildingStructure->structure_code_bus}}</span>
                                        {{$laborCost->buildingStructure->description_bus}}
                                        
                                    </td>
                                    <td>
                                        @switch($laborCost->activity_lac)
                                            @case('I')
                                                Instalacion
                                                <i class="fas fa-long-arrow-alt-down d-print-none"></i>
                                                @break
                                            @case('R')
                                                Retiro
                                                <i class="fas fa-long-arrow-alt-up d-print-none"></i>
                                                @break
                                            @case('M')
                                                Movimiento
                                                <i class="fas fa-arrows-alt-h d-print-none"></i>
                                                @break
                                        @endswitch
                                    </td>
                                    <td>{{$laborCost->execution_lac}}</td>
                                    <td class="text-end">{{number_format($laborCost->quantity_lac,2,'.',',')}}</td>
                                    <td class="text-end">{{number_format($laborCost->unit_price_lac,2,'.',',')}}</td>
                                    <td class="text-center">
                                        @switch($laborCost->is_additional_lac)
                                            @case(1)
                                                <span class="badge bg-danger d-print-none">SI</span>
                                                <div class="d-none d-print-block">SI</div>
                                                @break
                                            @case(0)
                                                <span class="badge bg-info d-print-none">NO</span>
                                                <div class="d-none d-print-block">NO</div>
                                                @break
                                        @endswitch
                                    </td>
                                    <td class="text-end">
                                        {{$laborCost->customStructureMaterials->count()}}
                                    </td>
                                    <td class="text-center d-print-none">
                                        @can('admin.labor-costs.edit')
                                            <a href="{{route('admin.labor-costs.edit', $laborCost)}}" class="btn btn-sm btn-primary py-0" target="_blank"><i class="fas fa-fw fa-pen"></i></a>    
                                        @endcan
                                    </td>
                                </tr>    
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    {{-- @stack('scripts') --}}
    <script src="{{asset('js/jQuery.print/jQuery.print.js')}}"></script>
    <script>
        $('#btn-print').on('click', function() {
            $.print($("#print-area").html());
            // let CSRF_TOKEN = $('meta[name="csrf-token"').attr('content');
            // let body = $("#print-area").html();
            // $.ajax({
            //     url: '{{route('admin.print')}}',
            //     type: 'POST',
            //     data: {
            //         _token: CSRF_TOKEN,
            //         body: body
            //     },
            //     beforeSend: function() {
            //         console.log('printing ...');
            //     },
            //     complete: function() {
            //         console.log('printed!');
            //     },
            //     success: function(viewContent) {
            //         $.print(viewContent);
            //     }
            // });
        });
    </script>
@stop
