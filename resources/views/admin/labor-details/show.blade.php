@extends('adminlte::page')

@section('title', 'Detalle de mano de obra: '.$laborDetail->project->code_pro)

@section('content_header')
    <h1>Detalle de mano de obra: {{$laborDetail->project->code_pro}}</h1>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg">
                {{-- <div class="card-header">
                    <h3 class="card-title">Proyecto: {{$laborDetail->project->code_pro}}</h3>
                </div> --}}

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
                                <th>Personalizar<br>materiales</th>
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
                                                <i class="fas fa-long-arrow-alt-down"></i>
                                                @break
                                            @case('R')
                                                Retiro
                                                <i class="fas fa-long-arrow-alt-up"></i>
                                                @break
                                            @case('M')
                                                Movimiento
                                                <i class="fas fa-arrows-alt-h"></i>
                                                @break
                                                
                                        @endswitch
                                    </td>
                                    <td>{{$laborCost->execution_lac}}</td>
                                    <td class="text-right">{{$laborCost->quantity_lac}}</td>
                                    <td class="text-right">{{$laborCost->unit_price_lac}}</td>
                                    <td class="text-center">
                                        @switch($laborCost->is_additional_lac)
                                            @case(1)
                                                <span class="badge badge-danger">SI</span>
                                                @break
                                            @case(0)
                                                <span class="badge badge-info">NO</span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td class="text-right">
                                        {{$laborCost->customStructureMaterials->count()}}
                                    </td>
                                    <td class="text-center">
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
