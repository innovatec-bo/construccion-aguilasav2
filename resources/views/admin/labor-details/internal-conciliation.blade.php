@extends('layouts.dashboard-layout')

@section('title', 'Conciliacion interna')

@section('breadcrumb')
    {{ Breadcrumbs::render('admin.labor-details.internal-conciliation', $laborDetail, $previousRoute) }}
@stop
@section('content')
    <div class="row justify-content-center" data-previous-route="{{$previousRoute}}">
        <div class="col-md-12">
            <div class="alert alert-info alert-dismissible d-print-none">
                <h5><i class="icon fas fa-info"></i> Nota!</h5>
                La presente lista esta basada en la composici&oacute;n estandar de materiales. Para editar la composicion de una estructura acceda al <a class="text-dark" href="{{route('admin.labor-details.show', $laborDetail)}}">detalle de la mano de obra</a> y haga click en el boton de lapiz
            </div>
        </div>
        <div class="col-md-12 mb-2 text-end">
            <a class="btn btn-sm btn-primary d-print-none float-right mx-1" href="{{url()->previous()}}">Volver</a>
            @can('admin.labor-details.export-internal-conciliation')
                <div class="btn-group btn-group-sm" style="">
                    {{-- not ready yet export file class --}}
                    {{-- <a href="{{route('admin.labor-details.export-internal-conciliation', $laborDetail->id_lad)}}" class="btn btn-primary d-print-none"><i class="far fa-file-excel"></i> Exportar</a> --}}
                    <a class="btn btn-info d-print-none float-right ml-2  text-white" href="javascript:void(0)" id="btn-print"><i class="fa fa-print fa-fw"></i>Imprimir</a>
                </div>
            @endcan
        </div>
        <div class="col-md-12 mb-3">
            <div class="card shadow-lg" id="print-area">
                <div class="card-header d-print-none">
                    <h4 class="card-title">
                        Materiales que deben ser retirados segun el archivo de mano de obra
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row invoice-info mb-3">
                        <div class="col-md-12 d-none d-print-block">
                            <h3 class="text-center mb-0">Conciliacion Interna</h3>
                            <h4 class="text-center mb-4">{!! ucfirst($laborDetail->environment['label']) !!}</h4>
                        </div>
                        <div class="col-sm-2 invoice-col">
                            <address class="mb-1">
                                <strong>Fiscal</strong><br>
                                @foreach ($laborDetail->project->statusLogResponsibles as $statusLogResponsible)
                                    @if ($statusLogResponsible->responsible->user->hasRole('Fiscal'))
                                        {{$statusLogResponsible->responsible->user->full_name}}
                                    @endif
                                @endforeach
                            </address>    
                        </div>
                        <div class="col-sm-2 invoice-col">
                            <address class="mb-1">
                                <strong>Constructor</strong><br>
                                @foreach ($laborDetail->project->statusLogResponsibles as $statusLogResponsible)
                                    @if ($statusLogResponsible->responsible->user->hasRole('Builder'))
                                        {{$statusLogResponsible->responsible->user->full_name}}
                                    @endif
                                @endforeach
                            </address>
                        </div>
                        <div class="col-sm-2 invoice-col">
                            <address class="mb-1">
                                <strong>Proyecto</strong><br>
                                {{$laborDetail->project->code_pro}}
                            </address>
                        </div>
                    </div>
                    @if (count($materialsToBeReturned) > 0)
                        <table class="table table-bordered table-sm table-hover table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>C&oacute;digo</th>
                                    {{-- <th>Presente en las<br>siguientes estructuras</th> --}}
                                    <th>Descripcion</th>
                                    <th>Cantidad a<br>retirar</th>
                                    <th>Cantidad devuelta<br>a almacen</th>
                                    <th>Diferencia</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($materialsToBeReturned as $key => $material)
                                    <tr>
                                        <td class="text-center">{{($key+1)}}</td>
                                        <td>{{$material['code_mat']}}</td>
                                        <td>{{$material['description_mat']}}</td>
                                        <td class="text-end">                    
                                            {{number_format($material['quantity_csm'],2)}} {{$material['unit_of_measurement_mat']}}
                                        </td>
                                        <td class="text-end" data-structures="{{substr($material['structures'],0,-2)}}">
                                            @if ($material['quantity_csm'] == $material['quantity_prm'])
                                                <p class="badge bg-success d-print-none mb-0">{{number_format($material['quantity_prm'],2)}} {{$material['unit_of_measurement_mat']}}</p>
                                            @elseif($material['quantity_prm'] > 0 && $material['quantity_csm'] > $material['quantity_prm'])
                                                <p class="badge bg-info d-print-none mb-0">{{number_format($material['quantity_prm'],2)}} {{$material['unit_of_measurement_mat']}}</p>
                                            @elseif($material['quantity_prm'] == 0)
                                                <p class="badge bg-danger d-print-none mb-0">{{number_format($material['quantity_prm'],2)}} {{$material['unit_of_measurement_mat']}}</p>
                                            @elseif($material['quantity_prm'] > $material['quantity_csm'])
                                                <p class="badge bg-warning d-print-none mb-0">{{number_format($material['quantity_prm'],2)}} {{$material['unit_of_measurement_mat']}}</p>
                                            @endif
                                            <p class="d-none d-print-inline mb-0">{{number_format($material['quantity_prm'],2)}} {{$material['unit_of_measurement_mat']}}</p>
                                        </td>
                                        <td class="text-end">
                                            {{number_format($material['quantity_csm']- $material['quantity_prm'],2)}} {{$material['unit_of_measurement_mat']}}
                                            @if (($material['quantity_csm']- $material['quantity_prm']) > 0)
                                                 <i class="fas fa-exclamation text-warning d-print-none"></i>    
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                
                                @foreach ($returnedMaterials as $key => $material)
                                    <tr class="bg-success">
                                        <td class="text-center">{{($key+1)}}</td>
                                        <td>{{$material['code_mat']}}</td>
                                        <td>{{$material['description_mat']}}</td>
                                        <td class="text-end">                    
                                            {{number_format($material['quantity_csm'],2)}} {{$material['unit_of_measurement_mat']}}
                                        </td>
                                        <td class="text-end">
                                            <p class="badge bg-warning mb-0">{{number_format($material['quantity_prm'],2)}} {{$material['unit_of_measurement_mat']}}</p>
                                        </td>
                                        <td class="text-end">
                                            {{number_format($material['quantity_csm']- $material['quantity_prm'],2)}} {{$material['unit_of_measurement_mat']}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else 
                        La mano de obra no presenta actividad de retiro
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
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