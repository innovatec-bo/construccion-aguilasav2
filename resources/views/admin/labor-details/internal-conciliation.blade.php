@extends('adminlte::page')

@section('title', 'Conciliacion internal')

@section('content_header')
    <h1>Conciliacion internal</h1>
@stop

@section('content')
    <div class="row justify-content-center">
        {{-- <div class="col-md-5">
            <div class="card card-primary">
                <div class="card-header">
                    <h4 class="card-title">
                        Materiales que deben ser retirados segun el archivo de mano de obra
                    </h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-info alert-dismissible">
                        <h5><i class="icon fas fa-info"></i> Nota!</h5>
                        Estos son los materials por defecto que estan configurados por cada estructura, si desea personalizar la composicion de una estructura haga click aqui
                        <strong>(La persoanlizacion afecta a otros proyectos).</strong>
                        </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Estructura</th>
                                <th>Codigo</th>
                                <th>Descripcion</th>
                                <th>Cantidad a<br>retirar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($laborDetail->laborCosts->where('activity_lac','R') as $laborCost)
                                @foreach ($laborCost->buildingStructure->defaultStructureMaterials as $defaultMaterial)
                                    <tr>
                                        <td>{{($defaultMaterial->structure->structure_code_bus)}}</td>
                                        <td>{{($defaultMaterial->material->code_mat)}}</td>
                                        <td>{{($defaultMaterial->material->description_mat)}}</td>
                                        <td class="text-right">{{$defaultMaterial->quantity_dsm}}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div> --}}
        <div class="col-md-5">
            <div class="card card-primary shadow-lg">
                <div class="card-header">
                    <h4 class="card-title">
                        Materiales que deben ser retirados segun el archivo de mano de obra
                    </h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-info alert-dismissible">
                        <h5><i class="icon fas fa-info"></i> Nota!</h5>
                        Estos son los materials por defecto que estan configurados por cada estructura, si desea personalizar la composicion de una estructura haga click aqui
                        <strong>(La personalizacion afecta a otros proyectos).</strong>
                        </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>C&oacute;digo</th>
                                <th>Descripcion</th>
                                <th>Cantidad a<br>retirar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($materials as $key => $material)
                                <tr>
                                    <td>{{($key+1)}}</td>
                                    <td>{{$material['code_mat']}}</td>
                                    <td>{{$material['description_mat']}}</td>
                                    <td class="text-right">
                                        
                                        <p class="badge bg-warning">{{number_format($material['quantity_dsm'],2)}} {{$material['unit_of_measurement_mat']}}</p>
                                        
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- @livewire('admin.labor-detail-index') --}}
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    {{-- <script> console.log('Hi!'); </script> --}}
@stop
