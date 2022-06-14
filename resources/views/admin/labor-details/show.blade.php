@extends('adminlte::page')

@section('title', 'Detalle de mano de obra: '.$laborDetail->project->code_pro)

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1>Detalle de mano de obra: {{$laborDetail->project->code_pro}}</h1>
        </div>
        <div class="col-sm-6">
            {{ Breadcrumbs::render('admin.labor-details.show', $laborDetail) }}
        </div>
    </div>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg">
                <div class="card-header">
                    <h2 class="text-center d-none d-print-block">Detalle de mano de obra: {{$laborDetail->project->code_pro}}</h2>
                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="">
                            @can('admin.labor-details.export')
                                <a href="{{route('admin.labor-details.export', $laborDetail->id_lad)}}" class="btn btn-primary btn-xs d-print-none"><i class="far fa-file-excel"></i> Exportar</a>
                                <a class="btn btn-info btn-xs d-print-none float-right ml-2" href="javascript:void(0)" onclick="window.print();"><i class="fa fa-print fa-fw"></i>Imprimir</a>
                            @endcan
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-sm table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Estructura</th>
                                <th>Actividad</th>
                                <th>Ejecucion</th>
                                <th>Cantidad</th>
                                <th>Precio<br>Unitario</th>
                                <th>Es<br>adicional?</th>
                                <th>Nro.<br>Materiales</th>
                                <th class="d-print-none">Personalizar<br>materiales</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($laborDetail->laborCosts as $laborCost)
                                <tr>
                                    <td>
                                        <span class="text-warning">{{$laborCost->buildingStructure->structure_code_bus}}</span>
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
                                    <td class="text-right">{{$laborCost->quantity_lac}}</td>
                                    <td class="text-right">{{$laborCost->unit_price_lac}}</td>
                                    <td class="text-center">
                                        @switch($laborCost->is_additional_lac)
                                            @case(1)
                                                <span class="badge badge-danger d-print-none">SI</span>
                                                <div class="d-none d-print-block">SI</div>
                                                @break
                                            @case(0)
                                                <span class="badge badge-info d-print-none">NO</span>
                                                <div class="d-none d-print-block">NO</div>
                                                @break
                                        @endswitch
                                    </td>
                                    <td class="text-right">
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
    @stack('scripts')
    {{-- <script> console.log('Hi!'); </script> --}}
@stop
