@extends('adminlte::page')

@section('title', 'Conciliacion internal(Vista de constructor)')

@section('content_header')
    <h1>Conciliacion internal(Vista de constructor)</h1>
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
                    @if (count($materialsToBeReturned) > 0)
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>C&oacute;digo</th>
                                    <th>Descripcion</th>
                                    <th>Cantidad a<br>retirar</th>
                                    <th>Cantidad registrada<br>en almacen</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i =1;
                                @endphp
                                @foreach ($materialsToBeReturned as $key => $material)
                                    @if ($material['quantity_prm'] == 0 || $material['quantity_prm'] < $material['quantity_dsm'])
                                        <tr>
                                            <td>{{($i)}}</td>
                                            <td>{{$material['code_mat']}}</td>
                                            <td>{{$material['description_mat']}}</td>
                                            <td class="text-right">                    
                                                {{number_format($material['quantity_dsm'],2)}} {{$material['unit_of_measurement_mat']}}
                                            </td>
                                            <td class="text-right">
                                                @if ($material['quantity_dsm'] == $material['quantity_prm'])
                                                    <p class="badge bg-success">{{number_format($material['quantity_prm'],2)}} {{$material['unit_of_measurement_mat']}}</p>
                                                @elseif($material['quantity_prm'] > 0 && $material['quantity_dsm'] > $material['quantity_prm'])
                                                    <p class="badge bg-info">{{number_format($material['quantity_prm'],2)}} {{$material['unit_of_measurement_mat']}}</p>
                                                @elseif($material['quantity_prm'] == 0)
                                                    <p class="badge bg-danger">{{number_format($material['quantity_prm'],2)}} {{$material['unit_of_measurement_mat']}}</p>
                                                @elseif($material['quantity_prm'] > $material['quantity_dsm'])
                                                    <p class="badge bg-warning">{{number_format($material['quantity_prm'],2)}} {{$material['unit_of_measurement_mat']}}</p>
                                                @endif
                                                
                                            </td>
                                        </tr>
                                        @php
                                            $i++;
                                        @endphp    
                                    @endif
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
