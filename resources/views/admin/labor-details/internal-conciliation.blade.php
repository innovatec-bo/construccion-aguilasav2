@extends('adminlte::page')

@section('title', 'Conciliacion internal')

@section('content_header')
    <h1>Conciliacion internal: {{$laborDetail->project->code_pro}}</h1>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card card-primary shadow-lg">
                <div class="card-header">
                    <h4 class="card-title">
                        Materiales que deben ser retirados segun el archivo de mano de obra
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <a class="btn btn-primary d-print-none float-right mx-1" href="{{url()->previous()}}">Volver</a>
                            <a class="btn btn-info d-print-none float-right" href="javascript:void(0)" onclick="window.print();"><i class="fa fa-print fa-fw"></i>Imprimir</a>
                        </div>
                    </div>
                    <div class="alert alert-info alert-dismissible d-print-none">
                        <h5><i class="icon fas fa-info"></i> Nota!</h5>
                        La presente lista esta basada en la composici&oacute;n estandar de materiales. Para editar la composicion de una estructura acceda al <a class="text-dark" href="{{route('admin.labor-details.show', $laborDetail)}}">detalle de la mano de obra</a> y haga click en el boton de lapiz
                    </div>
                    @if (count($materialsToBeReturned) > 0)
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>C&oacute;digo</th>
                                    {{-- <th>Presente en las<br>siguientes estructuras</th> --}}
                                    <th>Descripcion</th>
                                    <th>Cantidad a<br>retirar</th>
                                    <th>Cantidad registrada<br>en almacen</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($materialsToBeReturned as $key => $material)
                                    <tr>
                                        <td>{{($key+1)}}</td>
                                        <td>{{$material['code_mat']}}</td>
                                        {{-- <td>{{ substr($material['structures'],0,-2)}}</td> --}}
                                        <td>{{$material['description_mat']}}</td>
                                        <td class="text-right">                    
                                            {{number_format($material['quantity_csm'],2)}} {{$material['unit_of_measurement_mat']}}
                                        </td>
                                        <td class="text-right" data-structures="{{substr($material['structures'],0,-2)}}">
                                            @if ($material['quantity_csm'] == $material['quantity_prm'])
                                                <p class="badge bg-success">{{number_format($material['quantity_prm'],2)}} {{$material['unit_of_measurement_mat']}}</p>
                                            @elseif($material['quantity_prm'] > 0 && $material['quantity_csm'] > $material['quantity_prm'])
                                                <p class="badge bg-info">{{number_format($material['quantity_prm'],2)}} {{$material['unit_of_measurement_mat']}}</p>
                                            @elseif($material['quantity_prm'] == 0)
                                                <p class="badge bg-danger">{{number_format($material['quantity_prm'],2)}} {{$material['unit_of_measurement_mat']}}</p>
                                            @elseif($material['quantity_prm'] > $material['quantity_csm'])
                                                <p class="badge bg-warning">{{number_format($material['quantity_prm'],2)}} {{$material['unit_of_measurement_mat']}}</p>
                                            @endif
                                            
                                        </td>
                                    </tr>
                                @endforeach
                                
                                @foreach ($returnedMaterials as $key => $material)
                                    <tr class="bg-success">
                                        <td>{{($key+1)}}</td>
                                        <td>{{$material['code_mat']}}</td>
                                        {{-- <td>{{ substr($material['structures'],0,-2)}}</td> --}}
                                        <td>{{$material['description_mat']}}</td>
                                        <td class="text-right">                    
                                            {{number_format($material['quantity_csm'],2)}} {{$material['unit_of_measurement_mat']}}
                                        </td>
                                        <td class="text-right">
                                            <p class="badge bg-warning">{{number_format($material['quantity_prm'],2)}} {{$material['unit_of_measurement_mat']}}</p>
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
    {{-- @livewire('admin.labor-detail-index') --}}
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    <style>
        @page {
            size: letter;
        }
        @media print {
        * { background: transparent !important; color: black !important; box-shadow:none !important; text-shadow: none !important; filter:none !important; -ms-filter: none !important; } /* Black prints faster: h5bp.com/s */
            a, a:visited { text-decoration: underline; }
            a[href]:after { content: " (" attr(href) ")"; }
            abbr[title]:after { content: " (" attr(title) ")"; }
            .ir a:after, a[href^="javascript:"]:after, a[href^="#"]:after { content: ""; } /* Don't show links for images, or javascript/internal links */
            pre, blockquote { border: 1px solid #999; page-break-inside: avoid; }
            thead { display: table-header-group; } /* h5bp.com/t */
            tr, img { page-break-inside: avoid; }
            img { max-width: 100% !important; }
            @page { margin: 0.5cm; }
            p, h2, h3 { orphans: 3; widows: 3; }
            h2, h3 { page-break-after: avoid; }
            div.shadow-lg {
                -webkit-box-shadow: none!important;
                -moz-box-shadow:    none!important;
                box-shadow:         none!important; 
            }
        }
    </style>
@stop

@section('js')
    {{-- <script> console.log('Hi!'); </script> --}}
@stop